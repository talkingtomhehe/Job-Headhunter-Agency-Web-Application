document.addEventListener('DOMContentLoaded', function() {
    // Role tab switching
    const roleTabs = document.querySelectorAll('.role-tab');
    const job_seekerContent = document.getElementById('job_seekerContent');
    const employerLoginContent = document.getElementById('employerLoginContent');
    const employerContent = document.getElementById('employerContent');
    const job_seekerRegisterContent = document.getElementById('job_seekerRegisterContent');
    const registerOption = document.getElementById('registerOption');
    const socialLoginSection = document.querySelector('.social-login-section');
    const socialDivider = document.querySelector('.auth-divider:last-of-type');
    const userRoleInput = document.getElementById('user_role');
    
    // By default, show the job_seeker content
    if (job_seekerContent) {
        job_seekerContent.classList.add('active');
    }
    if (employerLoginContent) {
        employerLoginContent.classList.remove('active');
    }
    if (employerContent) {
        employerContent.classList.remove('active');
    }
    if (job_seekerRegisterContent) {
        job_seekerRegisterContent.classList.remove('active');
    }
    
    roleTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active tab
            roleTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const role = this.getAttribute('data-role');
            if (userRoleInput) {
                userRoleInput.value = role;
            }
            
            // Always show login form when switching tabs
            if (job_seekerContent) job_seekerContent.classList.remove('active');
            if (employerLoginContent) employerLoginContent.classList.remove('active');
            if (employerContent) employerContent.classList.remove('active');
            if (job_seekerRegisterContent) job_seekerRegisterContent.classList.remove('active');
            
            if (role === 'job_seeker') {
                if (job_seekerContent) job_seekerContent.classList.add('active');
            } else if (role === 'employer') {
                if (employerLoginContent) employerLoginContent.classList.add('active');
            }
            
            // Always show register option and social login
            if (registerOption) registerOption.style.display = 'block';
            if (socialLoginSection) socialLoginSection.style.display = 'block';
            if (socialDivider) socialDivider.style.display = 'block';
        });
    });
    
    // Initialize based on active tab
    const activeTab = document.querySelector('.role-tab.active');
    if (activeTab) {
        activeTab.click(); // Trigger the click event to set initial state
    }
    
    // Toggle to registration form when register link is clicked
    const showRegisterForm = document.getElementById('showRegisterForm');
    if (showRegisterForm) {
        showRegisterForm.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get current active role tab value
            const activeRole = document.querySelector('.role-tab.active').getAttribute('data-role');
            
            // Hide login form
            if (job_seekerContent) job_seekerContent.classList.remove('active');
            if (employerLoginContent) employerLoginContent.classList.remove('active');
            
            // Show registration form based on role
            if (activeRole === 'job_seeker') {
                if (job_seekerRegisterContent) job_seekerRegisterContent.classList.add('active');
            } else if (activeRole === 'employer') {
                if (employerContent) employerContent.classList.add('active');
            }
        });
    }
});