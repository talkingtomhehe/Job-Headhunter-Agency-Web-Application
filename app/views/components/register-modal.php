<div id="registerModal" class="modal" onclick="if(event.target===this) this.style.display='none';">
    <div class="modal-content register-modal-content">
        <button type="button" class="close-button" onclick="document.getElementById('registerModal').style.display='none';">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <h2 class="modal-title">Create an Account</h2>
        
        <form action="/huntly/public/register" method="POST">
            <div class="form-group">
                <label for="username">Username <span class="required">*</span></label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">
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
            
            <div class="terms-agreement">
                By signing up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
            </div>
            
            <button type="submit" class="register-submit-btn">Register Now</button>
            
            <div class="modal-switch">
                Already have an account? <a href="#" id="switchToLogin" class="login-link">Login</a>
            </div>
        </form>
    </div>
</div>