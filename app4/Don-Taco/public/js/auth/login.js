document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(this);

    // Remove previous error feedback
    form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.getElementById('generalError').textContent = '';

    try {
        const response = await fetch('authLogin', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            window.location.href = result.redirect;
        } else {
            for (const field in result.errors) {
                const input = form.querySelector(`[name="${field}"]`);

                if (input) {
                    input.classList.add('is-invalid');

                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = result.errors[field];

                    input.parentElement.appendChild(feedback);
                } else if (field === 'general') {
                    document.getElementById('generalError').textContent = result.errors.general;
                }
            }
        }
    } catch (error) {
        document.getElementById('generalError').textContent = 'Something went wrong. Try again later.';
    }
});
