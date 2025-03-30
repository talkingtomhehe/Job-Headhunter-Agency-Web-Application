<div id="loginModal" class="modal" onclick="if(event.target===this) this.style.display='none';">
    <div class="modal-content register-modal-content">
        <button type="button" class="close-button" onclick="document.getElementById('loginModal').style.display='none';">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <h2 class="modal-title">Login to Your Account</h2>
        
        <form action="/huntly/public/login" method="POST">
            <div class="form-group">
                <label for="login-username">Username <span class="required">*</span></label>
                <input type="text" id="login-username" name="username" placeholder="Enter your username" required>
            </div>
            
            <div class="form-group">
                <label for="login-password">Password <span class="required">*</span></label>
                <div class="password-container">
                    <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                    <i class="fa-solid fa-eye password-toggle"></i>
                </div>
            </div>
            
            <div class="remember-row">
                <div class="checkbox-container">
                    <input type="checkbox" id="remember-me" name="remember">
                    <label for="remember-me" class="checkbox-label">Keep me signed in</label>
                </div>
                <a href="#" class="forgot-password">Forgotten password?</a>
            </div>
            
            <button type="submit" class="register-submit-btn">Login</button>
            
            <div class="modal-switch">
                Don't have an account? <a href="#" id="switchToRegister" class="login-link">Register</a>
            </div>
            
            <div class="social-login">
                <button type="button" class="social-btn google-btn">
                    <i class="fa-brands fa-google"></i> Continue with Google
                </button>
                <button type="button" class="social-btn facebook-btn">
                    <i class="fa-brands fa-facebook"></i> Continue with Facebook
                </button>
            </div>
        </form>
    </div>
</div>