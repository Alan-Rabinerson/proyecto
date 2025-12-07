let firstNameInput = document.getElementById('first_name');
let lastNameInput = document.getElementById('last_name');
let emailInput = document.getElementById('email');
let usernameInput = document.getElementById('username');
let passwordInput = document.getElementById('password');
let confirmPasswordInput = document.getElementById('confirm_password');
let phoneInput = document.getElementById('phone');
let registerForm = document.getElementById('registerForm');

document.addEventListener('DOMContentLoaded', function() {
    confirmPasswordInput.addEventListener('blur', () => {
        if (passwordInput.value !== confirmPasswordInput.value && confirmPasswordInput.value !== '') {
            let errorDiv = document.createElement('div');
            let confirmPasswordDiv = document.getElementById('confirmPasswordDiv');
            errorDiv.className = 'bg-red-500 text-white p-2 mb-4 rounded';
            errorDiv.innerText = 'Passwords do not match.';
            confirmPasswordDiv.append(errorDiv);
            return;
        } else {
            let confirmPasswordDiv = document.getElementById('confirmPasswordDiv');
            let errorMessages = confirmPasswordDiv.querySelectorAll('.bg-red-500');
            errorMessages.forEach(msg => msg.remove());
        }
            
    });

    emailInput.addEventListener('blur', () => {
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            let emailDiv = document.getElementById('emailDiv');
            let errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-500 text-white p-2 mb-4 rounded';
            errorDiv.innerText = 'Please enter a valid email address.';
            emailDiv.append(errorDiv);
            return;
        } else {
            let emailDiv = document.getElementById('emailDiv');
            let errorMessages = emailDiv.querySelectorAll('.bg-red-500');
            errorMessages.forEach(msg => msg.remove());
        }
    });

    usernameInput.addEventListener('blur', () => {
        let usernamePattern = /^[a-zA-Z0-9_]+$/;
        let usernameDiv = document.getElementById('usernameDiv');
        if (!usernamePattern.test(usernameInput.value)) {
            let errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-500 text-white p-2 mb-4 rounded';
            errorDiv.innerText = 'Username can only contain letters, numbers, and underscores.';
            usernameDiv.append(errorDiv);
            return;
        } else if (usernameInput.value.length < 5) {
            let errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-500 text-white p-2 mb-4 rounded';
            errorDiv.innerText = 'Username must be at least 5 characters long.';
            usernameDiv.append(errorDiv);
            return;
        } else {
            let errorMessages = usernameDiv.querySelectorAll('.bg-red-500');
            errorMessages.forEach(msg => msg.remove());
        }
    });

    phoneInput.addEventListener('blur', () => {
        let phonePattern = /^\+?[0-9]{7,15}$/;
        let phoneDiv = document.getElementById('phoneDiv');
        if (!phonePattern.test(phoneInput.value)) {
            let errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-500 text-white p-2 mb-4 rounded';
            errorDiv.innerText = 'Please enter a valid phone number.';
            phoneDiv.append(errorDiv);
            return;
        } else {
            let errorMessages = phoneDiv.querySelectorAll('.bg-red-500');
            errorMessages.forEach(msg => msg.remove());
        }
    });

    firstNameInput.addEventListener('blur', () => {
        let namePattern = /^[a-zA-Z'-]+$/;
        let firstNameDiv = document.getElementById('firstNameDiv');
        if (!namePattern.test(firstNameInput.value)) {
            let errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-500 text-white p-2 mb-4 rounded';
            errorDiv.innerText = 'First name can only contain letters, apostrophes, and hyphens.';
            firstNameDiv.append(errorDiv);
            return;
        }else {
            // Capitalize first letter
            firstNameInput.value = firstNameInput.value.charAt(0).toUpperCase() + firstNameInput.value.slice(1).toLowerCase();
            let errorMessages = firstNameDiv.querySelectorAll('.bg-red-500');
            errorMessages.forEach(msg => msg.remove());

        }
    });

    lastNameInput.addEventListener('blur', () => {
        let namePattern = /^[a-zA-Z'-]+$/;
        let lastNameDiv = document.getElementById('lastNameDiv');
        if (!namePattern.test(lastNameInput.value)) {
            let errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-500 text-white p-2 mb-4 rounded';
            errorDiv.innerText = 'Last name can only contain letters, apostrophes, and hyphens.';
            lastNameDiv.append(errorDiv);
            return;
        } else {
            // Capitalize first letter
            lastNameInput.value = lastNameInput.value.charAt(0).toUpperCase() + lastNameInput.value.slice(1).toLowerCase();
            let errorMessages = lastNameDiv.querySelectorAll('.bg-red-500');
            errorMessages.forEach(msg => msg.remove());

        }
    });

    registerForm.addEventListener('submit', (e) => {
        // Clear previous error messages
        let errorMessages = document.querySelectorAll('.bg-red-500');
        errorMessages.forEach(msg => msg.remove());
        // Final validation before submission
        if (passwordInput.value !== confirmPasswordInput.value) {
            e.preventDefault();
            let errorDiv = document.createElement('div');
            let confirmPasswordDiv = document.getElementById('confirmPasswordDiv');
            errorDiv.className = 'bg-red-500 text-white p-2 mb-4 rounded';
            errorDiv.innerText = 'Passwords do not match.';
            confirmPasswordDiv.append(errorDiv);
            return;
        }
    });

});