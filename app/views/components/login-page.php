<div class="auth-page-container">
    <div class="auth-left-panel">
        <h1 class="auth-heading">Login / Register</h1>

        <div class="auth-box">
            <!-- Role selector tabs -->
            <div class="role-selector">
                <button class="role-tab active" data-role="job_seeker">Job Seeker</button>
                <button class="role-tab" data-role="employer">Employer</button>
            </div>

            <hr class="auth-divider">

            <!-- Login Form -->
            <form id="loginForm" class="auth-form" action="<?= SITE_URL ?>/auth/login" method="POST">
                <input type="hidden" name="user_role" id="user_role" value="job_seeker">

                <div class="form-group">
                    <label for="login-email">Email <span class="required">*</span></label>
                    <input type="email" id="login-email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="login-password">Password <span class="required">*</span></label>
                    <div class="password-container">
                        <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                        <i class="fa-solid fa-eye password-toggle"></i>
                    </div>
                </div>

                <a href="/huntly/public/auth_controller.php?action=forgot_password" class="forgot-password">Forgotten password?</a>

                <button type="submit" class="auth-submit-btn">Login</button>

                <div id="registerOption" class="account-toggle">
                    Don't have an account? <a href="#" id="showRegisterForm" class="auth-link">Register</a>
                </div>

                <hr class="auth-divider">

                <div class="social-login-section">
                    <p class="social-login-label">or sign in with</p>
                    <div class="social-login-buttons">
                        <a href="<?= SITE_URL ?>/auth/googlelogin?role=<?= $role === 'employer' ? 'employer' : 'job_seeker' ?>" class="social-btn google-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                            </svg> Google
                        </a>
                        <button type="button" class="social-btn facebook-btn">
                            <i class="fa-brands fa-facebook"></i> Facebook
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="auth-right-panel">
        <!-- Content changes based on selected role -->
        <div id="job_seekerContent" class="right-panel-content active">
            <img src="/huntly/public/assets/images/job_seeker.svg" alt="Job Seeker Login" class="auth-image">
        </div>

        <div id="employerLoginContent" class="right-panel-content">
            <img src="/huntly/public/assets/images/headhunter.svg" alt="Employer Login" class="auth-image">
        </div>

        <div id="employerContent" class="right-panel-content">
            <h2 class="register-heading">Create Employer Account</h2>
            <form id="registerForm" class="auth-form needs-validation" action="<?= SITE_URL ?>/auth/register" method="POST" novalidate>
                <input type="hidden" name="user_role" value="employer">

                <div class="form-group">
                    <label for="full_name">Full Name <span class="required">*</span></label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Create a password" required>
                        <i class="fa-solid fa-eye password-toggle"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                    <div class="password-container">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        <i class="fa-solid fa-eye password-toggle"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="company_name">Company Name <span class="required">*</span></label>
                    <input type="text" id="company_name" name="company_name" placeholder="Enter your company name" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>

                <div class="terms-agreement">
                    By registering, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </div>

                <button type="submit" class="auth-submit-btn">Register Now</button>
            </form>
        </div>

        <!-- Job Seeker Registration Form -->
        <div id="job_seekerRegisterContent" class="right-panel-content">
            <h2 class="register-heading">Create Job Seeker Account</h2>
            <form id="seekerRegisterForm" class="auth-form needs-validation" action="<?= SITE_URL ?>/auth/register" method="POST" novalidate>
                <input type="hidden" name="user_role" value="job_seeker">

                <div class="form-group">
                    <label for="seeker_full_name">Full Name <span class="required">*</span></label>
                    <input type="text" id="seeker_full_name" name="full_name" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="seeker_email">Email <span class="required">*</span></label>
                    <input type="email" id="seeker_email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="seeker_password">Password <span class="required">*</span></label>
                    <div class="password-container">
                        <input type="password" id="seeker_password" name="password" placeholder="Create a password" required>
                        <i class="fa-solid fa-eye password-toggle"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="seeker_confirm_password">Confirm Password <span class="required">*</span></label>
                    <div class="password-container">
                        <input type="password" id="seeker_confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        <i class="fa-solid fa-eye password-toggle"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="seeker_phone">Phone Number</label>
                    <input type="tel" id="seeker_phone" name="phone" placeholder="Enter your phone number">
                </div>

                <div class="terms-agreement">
                    By registering, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </div>

                <button type="submit" class="auth-submit-btn">Register Now</button>
            </form>
        </div>
    </div>

    <!-- Registration Success Modal -->
    <div id="registration-success-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <i class="fa-solid fa-circle-check success-icon"></i>
                <h2>Registration Successful!</h2>
            </div>
            <div class="modal-body">
                <p>Your account has been created successfully. Please check your email to verify your account.</p>
                
                <?php if (isset($_SESSION['auth_warning'])): ?>
                    <div class="alert alert-warning">
                        <?= $_SESSION['auth_warning'] ?>
                        <?php unset($_SESSION['auth_warning']) ?>
                    </div>
                <?php endif; ?>

                <div id="modal-resend-verification" class="resend-section">
                    <p>Didn't receive verification email? <a href="<?= SITE_URL ?>/auth/resendverification" class="resend-link">Resend</a></p>
                </div>
            </div>
            <div class="modal-footer">
                <button id="close-registration-modal" class="btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get role tabs
    const roleTabs = document.querySelectorAll('.role-tab');
    
    // Get Google login button
    const googleBtn = document.querySelector('.google-btn');
    
    // Set initial role
    let currentRole = 'job_seeker';
    
    // Update Google login URL based on selected role
    roleTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            currentRole = this.getAttribute('data-role');
            if (googleBtn) {
                googleBtn.href = `<?= SITE_URL ?>/auth/googlelogin?role=${currentRole}`; // Changed from google-login
            }
        });
    });
    
    // Update hidden role field in login form
    const roleField = document.getElementById('user_role');
    if (roleField) {
        roleTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                roleField.value = this.getAttribute('data-role');
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if there's an error message about verification
    const errorMessages = document.querySelectorAll('.alert.alert-danger');
    errorMessages.forEach(message => {
        // If the error message mentions verification
        if (message.textContent.toLowerCase().includes('verify') || 
            message.textContent.toLowerCase().includes('verification')) {
            // Show the resend verification section
            const resendSection = document.getElementById('resend-verification');
            if (resendSection) {
                resendSection.style.display = 'block';
            }
        }
    });
});

// Check for successful registration
document.addEventListener('DOMContentLoaded', function() {
    // Show modal if registration was successful
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('registered') === 'true') {
        showRegistrationSuccessModal();
    }
    
    // Close modal when clicking the close button
    const closeModalButton = document.querySelector('.close-modal');
    if (closeModalButton) {
        closeModalButton.addEventListener('click', function() {
            document.getElementById('registration-success-modal').style.display = 'none';
        });
    }
    
    // Close modal when clicking the close button in footer
    const closeModalBtn = document.getElementById('close-registration-modal');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            document.getElementById('registration-success-modal').style.display = 'none';
        });
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('registration-success-modal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});

// Function to show the registration success modal
function showRegistrationSuccessModal() {
    const modal = document.getElementById('registration-success-modal');
    if (modal) {
        modal.style.display = 'block';
    }
}
</script>