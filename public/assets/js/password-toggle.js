document.addEventListener('DOMContentLoaded', function() {
    // Get all password toggle elements
    const toggleButtons = document.querySelectorAll('.password-toggle');
    
    toggleButtons.forEach(button => {
        // Initialize all toggles as eye icon (password hidden)
        button.classList.add('fa-eye');
        button.classList.remove('fa-eye-slash');
        
        button.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            
            if (passwordInput.type === 'password') {
                // Show password
                passwordInput.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash'); // With slash when visible
            } else {
                // Hide password
                passwordInput.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye'); // No slash when hidden
            }
        });
    });
});