document.addEventListener('DOMContentLoaded', function () {
    let toast = new Toasty();

    const resetForm = document.getElementById('resetRequestForm');
    const codeForm = document.getElementById('codeVerificationForm');
    const resendButton = document.getElementById('resendCode');
    let resendCooldown = 120;

    // Circle inputs and hidden input for the code
    const inputs = document.querySelectorAll('.code-circle');
    const hiddenInput = document.getElementById('reset-code');

    if (inputs.length && hiddenInput) {
        inputs.forEach((input, idx) => {
            input.addEventListener('input', () => {
                // Only allow digits
                input.value = input.value.replace(/[^0-9]/g, '');
                // Auto move to next input
                if (input.value && idx < inputs.length - 1) {
                    inputs[idx + 1].focus();
                }
                updateHiddenInput();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && idx > 0) {
                    inputs[idx - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').trim().slice(0, inputs.length);
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].value = pasteData[i] || '';
                }
                inputs[Math.min(pasteData.length, inputs.length - 1)].focus();
                updateHiddenInput();
            });
        });

        function updateHiddenInput() {
            hiddenInput.value = Array.from(inputs).map(i => i.value).join('');
        }
    }

    if (resetForm) {
        resetForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = resetForm.email.value.trim();

            const res = await fetch('requestReset', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ login: email })
            });

            const data = await res.json();

            if (data.success) {
                toast.success(data.message);
                document.getElementById('hiddenEmail').value = email;
                resetForm.classList.add('d-none');
                codeForm.classList.remove('d-none');
                startResendCooldown();
            } else {
                toast.error(data.error || 'Error');
            }
        });
    }

    if (resendButton) {
        resendButton.addEventListener('click', async () => {
            const email = document.getElementById('hiddenEmail').value;

            const res = await fetch('requestReset', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ login: email })
            });

            const data = await res.json();

            if (data.success) {
                toast.success(data.message);
                startResendCooldown();
            } else {
                toast.error(data.error || 'Error');
            }
        });
    }

    function startResendCooldown() {
        let remaining = resendCooldown;
        resendButton.disabled = true;

        const interval = setInterval(() => {
            remaining--;
            resendButton.innerText = `Reenviar en ${remaining}s`;

            if (remaining <= 0) {
                clearInterval(interval);
                resendButton.disabled = false;
                resendButton.innerText = 'Reenviar código';
            }
        }, 1000);
    }

    if (codeForm) {
        codeForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('hiddenEmail').value.trim();
            const code = hiddenInput.value.trim();
            const password = codeForm.password.value.trim();

            // Check code length
            if (code.length !== inputs.length) {
                toast.error('Por favor ingresa el código completo.');
                return;
            }

            const res = await fetch('resetPassword', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ login: email, code, password })
            });

            const data = await res.json();

            if (data.success) {
                toast.success(data.message);

                // Close Bootstrap modal
                const modalEl = document.getElementById('resetPasswordModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                modalInstance.hide();

                // Reset forms and inputs
                resetForm.reset();
                codeForm.reset();
                inputs.forEach(i => i.value = '');
                hiddenInput.value = '';

                resetForm.classList.remove('d-none');
                codeForm.classList.add('d-none');

                resendButton.disabled = false;
                resendButton.innerText = 'Reenviar código';
            } else {
                toast.error(data.error || 'Error al cambiar la contraseña');
            }
        });
    }
});
