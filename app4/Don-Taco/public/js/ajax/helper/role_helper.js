// role_helper.js

// Verifica si el usuario es administrador
function isAdmin() {
    return window.USER_ROLE === 'admin';
}

// Verifica si es un usuario regular
function isRegularUser() {
    return window.USER_ROLE === 'user';
}
