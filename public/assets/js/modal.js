/**
 * Modal functionality for Huntly site
 * Handles login and register modals
 */
document.addEventListener("DOMContentLoaded", function() {
    console.log("Modal script loaded");
    
    // Get modal elements
    const loginModal = document.getElementById("loginModal");
    const registerModal = document.getElementById("registerModal");
    
    // Get button elements
    const openLoginBtn = document.getElementById("openLoginModal");
    const openRegisterBtn = document.getElementById("openRegisterModal");
    
    // Modal functions
    function openLoginModal() {
        if (loginModal) {
            loginModal.style.display = "flex";
        }
    }
    
    function openRegisterModal() {
        if (registerModal) {
            registerModal.style.display = "flex";
        }
    }
    
    function closeLoginModal() {
        if (loginModal) {
            loginModal.style.display = "none";
            
            // Reset form fields
            const form = loginModal.querySelector("form");
            if (form) form.reset();
        }
    }
    
    function closeRegisterModal() {
        if (registerModal) {
            registerModal.style.display = "none";
            
            // Reset form fields
            const form = registerModal.querySelector("form");
            if (form) form.reset();
        }
    }
    
    function switchToLogin() {
        closeRegisterModal();
        openLoginModal();
    }
    
    function switchToRegister() {
        closeLoginModal();
        openRegisterModal();
    }
    
    // Set up event listeners
    
    // Open modal buttons
    if (openLoginBtn) {
        openLoginBtn.addEventListener("click", openLoginModal);
    }
    
    if (openRegisterBtn) {
        openRegisterBtn.addEventListener("click", openRegisterModal);
    }
    
    // FIXED: More direct approach to close buttons
    document.querySelectorAll(".close-button").forEach(button => {
        console.log("Close button found:", button);
        button.addEventListener("click", function(e) {
            e.stopPropagation(); // Prevent event bubbling
            console.log("Close button clicked directly");
            
            // Find parent modal and close it
            const modal = this.closest('.modal');
            if (modal) {
                console.log("Closing modal:", modal.id);
                if (modal.id === "loginModal") closeLoginModal();
                if (modal.id === "registerModal") closeRegisterModal();
            }
        });
    });
    
    // FIXED: More reliable outside click detection
    window.addEventListener("click", function(event) {
        console.log("Click detected on:", event.target);
        
        // Check if we clicked directly on the modal background (not its children)
        if (event.target === loginModal) {
            console.log("Outside login modal click detected");
            closeLoginModal();
        }
        
        if (event.target === registerModal) {
            console.log("Outside register modal click detected");
            closeRegisterModal();
        }
    });
    
    // Switch between modals
    const switchToLoginLink = document.getElementById("switchToLogin");
    const switchToRegisterLink = document.getElementById("switchToRegister");
    
    if (switchToLoginLink) {
        switchToLoginLink.addEventListener("click", function(event) {
            event.preventDefault();
            switchToLogin();
        });
    }
    
    if (switchToRegisterLink) {
        switchToRegisterLink.addEventListener("click", function(event) {
            event.preventDefault();
            switchToRegister();
        });
    }
    
    // Prevent form submission from closing modal
    const forms = document.querySelectorAll(".modal form");
    forms.forEach(form => {
        form.addEventListener("submit", function(event) {
            // For now, prevent default form submission to keep modal open
            event.preventDefault();
            console.log("Form submitted");
        });
    });
});