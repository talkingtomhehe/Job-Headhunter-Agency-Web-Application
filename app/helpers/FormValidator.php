<?php
namespace helpers;

class FormValidator {
    private $errors = [];
    private $data = [];
    
    public function __construct($data) {
        $this->data = $data;
    }
    
    public function validate($rules) {
        foreach ($rules as $field => $rule) {
            $fieldRules = explode('|', $rule);
            
            foreach ($fieldRules as $fieldRule) {
                // Check if rule has parameters
                if (strpos($fieldRule, ':') !== false) {
                    list($ruleName, $ruleValue) = explode(':', $fieldRule);
                } else {
                    $ruleName = $fieldRule;
                    $ruleValue = null;
                }
                
                $value = $this->data[$field] ?? null;
                
                // Call validation method
                $method = 'validate' . ucfirst($ruleName);
                if (method_exists($this, $method)) {
                    if (!$this->$method($field, $value, $ruleValue)) {
                        break; // Stop validating this field if one rule fails
                    }
                }
            }
        }
        
        return count($this->errors) === 0;
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function getError($field) {
        return $this->errors[$field] ?? '';
    }
    
    private function validateRequired($field, $value, $param) {
        if (empty($value)) {
            $this->errors[$field] = ucfirst($field) . ' is required';
            return false;
        }
        return true;
    }
    
    private function validateEmail($field, $value, $param) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'Please enter a valid email address';
            return false;
        }
        return true;
    }
    
    private function validateMin($field, $value, $param) {
        if (strlen($value) < $param) {
            $this->errors[$field] = ucfirst($field) . ' must be at least ' . $param . ' characters';
            return false;
        }
        return true;
    }
    
    private function validateMax($field, $value, $param) {
        if (strlen($value) > $param) {
            $this->errors[$field] = ucfirst($field) . ' must not exceed ' . $param . ' characters';
            return false;
        }
        return true;
    }
    
    private function validateMatch($field, $value, $param) {
        if ($value !== $this->data[$param]) {
            $this->errors[$field] = ucfirst($field) . ' does not match ' . $param;
            return false;
        }
        return true;
    }
    
    private function validateNumeric($field, $value, $param) {
        if (!is_numeric($value)) {
            $this->errors[$field] = ucfirst($field) . ' must be a number';
            return false;
        }
        return true;
    }
}