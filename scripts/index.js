// Function to validate the registration form
function validateRegistrationForm() {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (!name) {
        alert("Please enter your full name.");
        return false;
    }

    if (!validateEmail(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    if (password.length <= 10) {
        alert("Password must be at least 6 characters long.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true; // Form is valid
}

// Function to validate email format
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
// Function to validate the login form
function validateLoginForm() {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!validateEmail(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    if (!password) {
        alert("Please enter your password.");
        return false;
    }

    return true; // Form is valid
}



