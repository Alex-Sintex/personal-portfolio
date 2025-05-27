document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = new FormData(this);

    // Clear previous errors
    document.getElementById('loginError').textContent = '';
    document.getElementById('passwordError').textContent = '';
    document.getElementById('generalError').textContent = '';

    try {
        const response = await fetch('authLogin', {
            method: 'POST',
            body: form
        });

        const result = await response.json();

        if (result.success) {
            window.location.href = result.redirect;
        } else {
            if (result.errors.login) {
                document.getElementById('loginError').textContent = result.errors.login;
            }
            if (result.errors.password) {
                document.getElementById('passwordError').textContent = result.errors.password;
            }
            if (result.errors.general) {
                document.getElementById('generalError').textContent = result.errors.general;
            }
        }
    } catch (error) {
        document.getElementById('generalError').textContent = 'Something went wrong. Try again later.';
    }
});