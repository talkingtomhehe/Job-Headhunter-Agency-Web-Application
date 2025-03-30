document.addEventListener('DOMContentLoaded', function() {
    // Get all password toggle elements
    const toggleButtons = document.querySelectorAll('.password-toggle');
    
    toggleButtons.forEach(button => {
        // Make sure all toggles start as the eye icon (password hidden)
        button.classList.add('fa-eye-slash');
        button.classList.remove('fa-eye');
        
        button.addEventListener('click', function() {
            // Find the password input
            const passwordInput = this.previousElementSibling;
            
            // Toggle password visibility - REVERSED LOGIC
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'; // Show password
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password'; // Hide password
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            }
        });
    });
});