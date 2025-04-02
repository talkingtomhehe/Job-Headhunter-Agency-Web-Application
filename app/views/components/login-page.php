<div class="auth-page-container">
    <div class="auth-left-panel">
        <h1 class="auth-heading">Login / Register</h1>
        
        <div class="auth-box">
            <!-- Role selector tabs -->
            <div class="role-selector">
                <button class="role-tab active" data-role="admin">Admin</button>
                <button class="role-tab" data-role="employer">Employer</button>
            </div>
            
            <hr class="auth-divider">
            
            <!-- Login Form -->
            <form id="loginForm" class="auth-form" action="/huntly/public/login" method="POST">
                <div class="form-group">
                    <label for="login-username">Username/Email <span class="required">*</span></label>
                    <input type="text" id="login-username" name="username" placeholder="Enter your username or email" required>
                </div>
                
                <div class="form-group">
                    <label for="login-password">Password <span class="required">*</span></label>
                    <div class="password-container">
                        <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                        <i class="fa-solid fa-eye password-toggle"></i>
                    </div>
                </div>
                
                <a href="#" class="forgot-password">Forgotten password?</a>
                
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
        <div id="adminContent" class="right-panel-content active">
            <img src="/huntly/public/assets/images/admin.svg" alt="Admin Login" class="auth-image">
        </div>

        <div id="employerContent" class="right-panel-content">
            <h2 class="register-heading">Create Employer Account</h2>
            <form id="registerForm" class="auth-form" action="/huntly/public/register" method="POST">
                <div class="form-group">
                    <label for="username">Username <span class="required">*</span></label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
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
                    <label for="confirm-password">Confirm Password <span class="required">*</span></label>
                    <div class="password-container">
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                        <i class="fa-solid fa-eye password-toggle"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="company-name">Company Name <span class="required">*</span></label>
                    <input type="text" id="company-name" name="company-name" placeholder="Enter your company name" required>
                </div>
                
                <div class="form-group">
                    <label for="tax-number">Tax Number <span class="required">*</span></label>
                    <input type="text" id="tax-number" name="tax-number" placeholder="Enter your tax number" required>
                </div>
                
                <div class="form-group">
                    <label for="phone-number">Phone Number <span class="required">*</span></label>
                    <input type="tel" id="phone-number" name="phone-number" placeholder="Enter your phone number" required>
                </div>
                
                <div class="terms-agreement">
                    By registering, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </div>
                
                <button type="submit" class="auth-submit-btn">Register Now</button>
            </form>
        </div>
    </div>
</div>