<div id="loginModal" class="modal">
    <div class="modal-content">
        <button onclick=closeLoginBtn><i class="fa-solid fa-xmark"></i></button>
        <h2>Login to Huntly</h2>
        <form action="/huntly/public/login" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="#" id="switchToRegister">Register</a></p>
    </div>
</div>