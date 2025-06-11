const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

// For mobile, to ensure forms are hidden/shown correctly without overlay text
// This needs to be handled primarily by CSS media queries, but JS can add a class if needed.
// However, the current CSS is designed to handle this without explicit JS for mobile.
// The JS above just toggles the 'right-panel-active' class, which the CSS then interprets for mobile.

document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        const response = await fetch('login.php', { method: 'POST', body: formData });
        const result = await response.json();
        if (result.success) {
            window.location.href = result.redirect;
        } else {
            document.getElementById('loginError').textContent = result.message;
        }
    } catch (error) {
        document.getElementById('loginError').textContent = 'Terjadi kesalahan. Coba lagi.';
    }
});

document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        const response = await fetch('register.php', { method: 'POST', body: formData });
        const result = await response.json();
        if (result.success) {
            window.location.href = result.redirect;
        } else {
            document.getElementById('registerError').textContent = result.message;
        }
    } catch (error) {
        document.getElementById('registerError').textContent = 'Terjadi kesalahan. Coba lagi.';
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form'); // Assuming a form exists in the login page
    const messageBox = document.getElementById('message-box'); // Assuming an element with id 'message-box' exists

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
            });
            const result = await response.json();

            if (result.success) {
                messageBox.textContent = 'Login berhasil! Mengarahkan...';
                messageBox.style.color = 'green';
                setTimeout(() => {
                    window.location.href = result.redirect;
                }, 2000); // Redirect after 2 seconds
            } else {
                messageBox.textContent = result.message;
                messageBox.style.color = 'red';
            }
        } catch (error) {
            messageBox.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
            messageBox.style.color = 'red';
        }
    });
});