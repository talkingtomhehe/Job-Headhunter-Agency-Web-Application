document.addEventListener('DOMContentLoaded', function() {
    // Role tab switching
    const roleTabs = document.querySelectorAll('.role-tab');
    const adminContent = document.getElementById('adminContent');
    const employerContent = document.getElementById('employerContent');
    const registerOption = document.getElementById('registerOption');
    const socialLoginSection = document.querySelector('.social-login-section');
    const socialDivider = document.querySelector('.auth-divider:last-of-type');
    
    // By default, show the admin image for both tabs
    adminContent.classList.add('active');
    employerContent.classList.remove('active');
    
    roleTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active tab
            roleTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const role = this.getAttribute('data-role');
            
            // Always show the admin image when switching tabs
            adminContent.classList.add('active');
            employerContent.classList.remove('active');
            
            if (role === 'admin') {
                // Hide register option and social login for admin
                registerOption.style.display = 'none';
                socialLoginSection.style.display = 'none';
                socialDivider.style.display = 'none';
            } else {
                // Show register option and social login for employer
                registerOption.style.display = 'block';
                socialLoginSection.style.display = 'block';
                socialDivider.style.display = 'block';
            }
        });
    });
    
    // Initialize based on active tab
    const activeTab = document.querySelector('.role-tab.active');
    if (activeTab) {
        activeTab.click(); // Trigger the click event to set initial state
    }
    
    // Toggle to registration form ONLY when register link is clicked
    const showRegisterForm = document.getElementById('showRegisterForm');
    if (showRegisterForm) {
        showRegisterForm.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Make sure employer tab is active
            document.querySelector('.role-tab[data-role="employer"]').classList.add('active');
            document.querySelector('.role-tab[data-role="admin"]').classList.remove('active');
            
            // Now show the registration form
            adminContent.classList.remove('active');
            employerContent.classList.add('active');
            
            // Focus on first field of employer form
            document.getElementById('username').focus();
        });
    }
});