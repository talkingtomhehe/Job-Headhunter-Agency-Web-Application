document.addEventListener("DOMContentLoaded", function() {
    function openLoginModal() {
        document.getElementById("loginModal").style.display = "flex";
    }

    function openRegisterModal() {
        document.getElementById("registerModal").style.display = "flex";
    }

    function closeLoginModal() {
        document.getElementById("loginModal").style.display = "none";
    }

    function closeRegisterModal() {
        document.getElementById("registerModal").style.display = "none";
    }

    function switchToRegister() {
        closeLoginModal();
        openRegisterModal();
    }

    function switchToLogin() {
        closeRegisterModal();
        openLoginModal();
    }

    // open modal
    document.querySelectorAll(".login").forEach(button => {
        button.addEventListener("click", openLoginModal);
    });
    
    document.querySelectorAll(".register").forEach(button => {
        button.addEventListener("click", openRegisterModal);
    });

    // close modal
    document.querySelector(".close-login").addEventListener("click", closeLoginModal);
    document.querySelector(".close-register").addEventListener("click", closeRegisterModal);

    // switch modal
    document.getElementById("switchToRegister").addEventListener("click", function(event) {
        event.preventDefault();
        switchToRegister();
    });

    document.getElementById("switchToLogin").addEventListener("click", function(event) {
        event.preventDefault();
        switchToLogin();
    });

    // close modal on outside click
    window.addEventListener("click", function(event) {
        if (event.target === document.getElementById("loginModal")) {
            closeLoginModal();
        }
        if (event.target === document.getElementById("registerModal")) {
            closeRegisterModal();
        }
    });
});
