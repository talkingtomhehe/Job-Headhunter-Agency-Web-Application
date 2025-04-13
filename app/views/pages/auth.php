<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div id="auth-messages">
    <?php if (isset($_SESSION['auth_error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['auth_error']) ?>
        </div>
        <?php unset($_SESSION['auth_error']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['auth_success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['auth_success']) ?>
        </div>
        <?php unset($_SESSION['auth_success']); ?>
    <?php endif; ?>
</div>

<?php
// Include the login page component
include_once(COMPONENT_PATH . '/login-page.php');
?>