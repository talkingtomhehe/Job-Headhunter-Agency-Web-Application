<?php
namespace helpers;

class FileUpload {
    private $uploadPath;
    private $allowedTypes;
    private $maxSize;
    private $error;
    
    public function __construct($uploadPath = 'uploads', $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'], $maxSize = 5242880) {
        $this->uploadPath = $uploadPath; // Default upload path
        $this->allowedTypes = $allowedTypes; // Default allowed file types
        $this->maxSize = $maxSize; // Default max file size (5MB)
    }
    
    public function upload($file, $newFileName = null) {
        // Check if file was uploaded without errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->error = $this->getUploadErrorMessage($file['error']);
            return false;
        }
        
        // Check file size
        if ($file['size'] > $this->maxSize) {
            $this->error = 'File size exceeds the maximum limit of ' . ($this->maxSize / 1048576) . 'MB';
            return false;
        }
        
        // Get file info
        $fileName = $file['name'];
        $fileTmpPath = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Check file extension
        if (!in_array($fileExtension, $this->allowedTypes)) {
            $this->error = 'File type not allowed. Allowed types: ' . implode(', ', $this->allowedTypes);
            return false;
        }
        
        // Create upload directory if it doesn't exist
        $uploadDir = PUBLIC_PATH . '/' . $this->uploadPath;
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate unique filename if not provided
        if ($newFileName === null) {
            $newFileName = uniqid() . '.' . $fileExtension;
        } else {
            $newFileName = $newFileName . '.' . $fileExtension;
        }
        
        $targetFilePath = $uploadDir . '/' . $newFileName;
        
        // Upload file
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            return $this->uploadPath . '/' . $newFileName; // Return relative path
        } else {
            $this->error = 'Failed to upload file. Please try again.';
            return false;
        }
    }
    
    public function getError() {
        return $this->error;
    }
    
    private function getUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'A PHP extension stopped the file upload';
            default:
                return 'Unknown upload error';
        }
    }
}