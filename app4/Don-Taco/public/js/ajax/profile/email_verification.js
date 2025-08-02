document.addEventListener('DOMContentLoaded', function () {
    const resendBtn = document.getElementById('resend-verification');
    const alertBox = document.getElementById('verify-alert');
    const messageSpan = document.getElementById('verify-message');
    const iconSpan = document.getElementById('verify-icon');
    const emailNotVerified = document.getElementById('email-not-verified');

    function showVerifiedAlert() {
        if (!alertBox || !messageSpan || !iconSpan) return;

        // Hide "email not verified" warning if shown
        if (emailNotVerified) emailNotVerified.style.display = 'none';

        // Show the pulse alert with message and icon
        messageSpan.textContent = '¡Correo verificado con éxito!';
        iconSpan.innerHTML = '✅'; // simple emoji, or replace with icon font
        alertBox.style.display = 'block';
        alertBox.classList.add('pulse-alert');

        // Remove pulse effect and fade out after 3 seconds
        setTimeout(() => {
            alertBox.classList.remove('pulse-alert');
            alertBox.classList.add('fade-out');
            setTimeout(() => {
                alertBox.style.display = 'none';
                alertBox.classList.remove('fade-out');
                messageSpan.textContent = '';
                iconSpan.innerHTML = '';
            }, 500);
        }, 3000);
    }

    if (resendBtn) {
        resendBtn.addEventListener('click', async function (e) {
            e.preventDefault();
            try {
                const res = await fetch('verification/resend', {
                    method: 'POST',
                    credentials: 'same-origin',
                });
                const data = await res.json();

                if (data.status === 'success') {
                    toast.success(data.message);
                    // Optional: call showVerifiedAlert() here if relevant
                } else {
                    toast.error(data.message);
                }
            } catch (err) {
                toast.error('Error al enviar el correo de verificación');
            }
        });
    }

    // Pass a flag in URL like ?verified=success, show pulse alert
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('verified') === 'success') {
        showVerifiedAlert();
    }
});
