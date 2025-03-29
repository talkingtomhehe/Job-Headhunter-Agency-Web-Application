<div id="registerModal" class="modal">
    <div class="modal-content">
        <button class="close-button"><i class="fa-solid fa-xmark"></i></button>
        <h2>Create an account</h2>
        <form action="/huntly/public/register" method="POST">
            <label for="username">Username <span class="required">*</span></label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password <span class="required">*</span></label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password <span class="required">*</span></label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="#" id="switchToLogin">Login</a></p>
    </div>
</div>