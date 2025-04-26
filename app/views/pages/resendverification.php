<main class="container auth-container">
    <div class="auth-box resend-box">
        <h2>Resend Verification Email</h2>
        
        <?php if (isset($_SESSION['auth_error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['auth_error'] ?>
                <?php unset($_SESSION['auth_error']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['auth_success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['auth_success'] ?>
                <?php unset($_SESSION['auth_success']); ?>
            </div>
        <?php endif; ?>
        
        <form action="<?= SITE_URL ?>/auth/resendverification" method="POST" class="auth-form">
            <div class="form-group">
                <label for="email" id="email-address">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            </div>
            
            <button type="submit" class="auth-submit-btn">Resend Verification Email</button>
        </form>
        
        <div class="auth-links">
            <a href="<?= SITE_URL ?>/auth">Back to Login</a>
        </div>
    </div>
</main>

<style>
.resend-box {
    max-width: 500px;
    margin: 80px auto;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    background-color: white;
}

.auth-links {
    text-align: center;
    margin-top: 20px;
}

.auth-links a {
    color: #0631BC;
    text-decoration: none;
}

.auth-links a:hover {
    text-decoration: underline;
}
</style>