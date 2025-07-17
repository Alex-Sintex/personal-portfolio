$('#confirmDeleteBtn').click(function () {
    const password = $('#confirmPassword').val().trim();

    if (!password) {
        toast.error('Por favor, ingresa tu contraseña para confirmar.');
        return;
    }

    fetch('account/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ password: password })
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                toast.success(data.message || 'Cuenta eliminada.');
                setTimeout(() => window.location.href = '/auth/login', 2500);
            } else {
                toast.error(data.message || 'No se pudo eliminar la cuenta.');
            }
        })
        .catch(() => {
            toast.error('Error del servidor.');
        });
});