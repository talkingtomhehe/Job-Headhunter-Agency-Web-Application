document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!validateForm(form)) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
        
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                validateField(this);
            });
            
            input.addEventListener('blur', function() {
                validateField(this);
            });
        });
    });
    
    function validateForm(form) {
        let isValid = true;
        
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        // check password matching 
        const password = form.querySelector('input[name="password"]');
        const confirmPassword = form.querySelector('input[name="confirm_password"]');
        
        if (password && confirmPassword && password.value !== confirmPassword.value) {
            setFieldError(confirmPassword, 'Confirm password does not match');
            isValid = false;
        }
        
        return isValid;
    }
    
    // Modify the validateField function to always perform validation regardless of previous state
    function validateField(field) {
        // Always reset validation state first
        clearFieldError(field);

        // Empty required fields validation
        if (field.hasAttribute('required') && field.value.trim() === '') {
            setFieldError(field, 'This field is required');
            return false;
        }

        // check full name
        if ((field.name === 'full_name' || field.id === 'seeker_full_name') && field.value) {
            if (field.value.length < 2) {
                setFieldError(field, 'Full name must be at least 2 characters long');
                return false;
            }
            
            // Kiểm tra xem họ tên có chứa ký tự đặc biệt không
            const nameRegex = /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$/;
            if (!nameRegex.test(field.value)) {
                setFieldError(field, 'Full name cannot contain special characters');
                return false;
            }
        }

        // check email
        if (field.type === 'email' && field.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value)) {
                setFieldError(field, 'Invalid email format');
                return false;
            }
        }
        
        // check password length - Always check when field is a password field
        if (field.type === 'password' && field.name === 'password' && field.value) {
            if (field.value.length < 8) {
                setFieldError(field, 'Password must be at least 8 characters long');
                return false;
            }
            
            // check character strength
            const hasUpperCase = /[A-Z]/.test(field.value);
            const hasLowerCase = /[a-z]/.test(field.value);
            const hasNumbers = /\d/.test(field.value);
            const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(field.value);
            
            if (!(hasUpperCase && hasLowerCase && hasNumbers && hasSpecialChars)) {
                setFieldError(field, 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character');
                return false;
            }
        }
        
        // Always check password confirmation fields
        if (field.name === 'confirm_password' && field.value) {
            const password = field.form.querySelector('input[name="password"]');
            if (password && field.value !== password.value) {
                setFieldError(field, 'Confirm password does not match');
                return false;
            }
        }
        
        if (field.name === 'phone' && field.value) {
            const phoneRegex = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;
            if (!phoneRegex.test(field.value)) {
                setFieldError(field, 'Phone number must be in the format 84XXXXXXXXX or 0XXXXXXXXX');
                return false;
            }
        }
        
        // If we reach here, field is valid
        setFieldSuccess(field);
        return true;
    }
    
    function setFieldError(field, message) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
        
        let feedback = null;

        if (field.parentElement.classList.contains('password-container')) {
            feedback = field.parentElement.nextElementSibling;
        } else {
            feedback = field.nextElementSibling;
        }

        if (!feedback || !feedback.classList.contains('invalid-feedback')) {
            feedback = document.createElement('div');
            feedback.classList.add('invalid-feedback');
            if (field.parentElement.classList.contains('password-container')) {
                field.parentElement.insertAdjacentElement('afterend', feedback);
            } else {
                field.insertAdjacentElement('afterend', feedback);
            }
        }
        
        feedback.textContent = message;
        feedback.style.display = 'block'; 
    }
    
    function setFieldSuccess(field) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');

        let feedback = null;

        if (field.parentElement.classList.contains('password-container')) {
            feedback = field.parentElement.nextElementSibling;
        } else {
            feedback = field.nextElementSibling;
        }

        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.style.display = 'none';
        }
    }
    
    function clearFieldError(field) {
        field.classList.remove('is-invalid');
        field.classList.remove('is-valid');
    }
});

// Add an additional event listener to properly handle validation on any field change
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            // Add 'input' event to catch all changes including paste, autocomplete, etc.
            input.addEventListener('input', function() {
                validateField(this);
                
                // Also check confirm password if this is the password field
                if (this.name === 'password') {
                    const confirmPassword = form.querySelector('input[name="confirm_password"]');
                    if (confirmPassword && confirmPassword.value) {
                        validateField(confirmPassword);
                    }
                }
            });
        });
    });
});
