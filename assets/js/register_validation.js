document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.getElementById("register-form");

    registerForm.addEventListener("submit", function (event) {
        const name = document.getElementById("register-name").value.trim();
        const email = document.getElementById("register-email").value.trim();
        const password = document.getElementById("register-password").value.trim();
        const confirmPassword = document.getElementById("register-confirm-password").value.trim();

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email validation regex
        let errorMessage = "";

        // Validate Name
        if (!name) {
            errorMessage = "Name is required.";
        }

        // Validate Email
        if (!email) {
            errorMessage = errorMessage ? errorMessage + " Email is required." : "Email is required.";
        } else if (!emailRegex.test(email)) {
            errorMessage = errorMessage ? errorMessage + " Enter a valid email address." : "Enter a valid email address.";
        }

        // Validate Password
        if (!password) {
            errorMessage = errorMessage ? errorMessage + " Password is required." : "Password is required.";
        } else if (password.length < 6) {
            errorMessage = errorMessage ? errorMessage + " Password must be at least 6 characters." : "Password must be at least 6 characters.";
        }

        // Validate Confirm Password
        if (!confirmPassword) {
            errorMessage = errorMessage ? errorMessage + " Confirm Password is required." : "Confirm Password is required.";
        } else if (password !== confirmPassword) {
            errorMessage = errorMessage ? errorMessage + " Passwords do not match." : "Passwords do not match.";
        }

        // If there is any error, prevent form submission and alert the user
        if (errorMessage) {
            event.preventDefault();
            alert(errorMessage);
        }
    });
});
