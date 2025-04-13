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
                
                <a href="/huntlyversion2/public/auth_controller.php?action=forgot_password" class="forgot-password">Forgotten password?</a>
                
                <button type="submit" class="auth-submit-btn">Login</button>
                
                <div id="registerOption" class="account-toggle">
                    Don't have an account? <a href="#" id="showRegisterForm" class="auth-link">Register</a>
                </div>
                
                <hr class="auth-divider">
                
                <div class="social-login-section">
                    <p class="social-login-label">or sign in with</p>
                    <div class="social-login-buttons">
                        <button type="button" class="social-btn google-btn">
                            <i class="fa-brands fa-google"></i> Google
                        </button>
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
            <img src="/huntlyversion2/public/assets/images/job_seeker.svg" alt="Job Seeker Login" class="auth-image">
        </div>

        <div id="employerLoginContent" class="right-panel-content">
            <img src="/huntlyversion2/public/assets/images/headhunter.svg" alt="Employer Login" class="auth-image">
        </div>

        <div id="employerContent" class="right-panel-content">
            <h2 class="register-heading">Create Employer Account</h2>
            <form id="registerForm" class="auth-form" action="<?= SITE_URL ?>/auth/register" method="POST">
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
            <form id="seekerRegisterForm" class="auth-form" action="<?= SITE_URL ?>/auth/register" method="POST">
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
</div>