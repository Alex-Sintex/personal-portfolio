function confirmLogout() {
    Swal.fire({
        title: '¿Seguro que quieres cerrar la sesión?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user clicks "Yes, log out," redirect to the logout URL
            window.location.href = 'logout/logout';
        }
    });
}