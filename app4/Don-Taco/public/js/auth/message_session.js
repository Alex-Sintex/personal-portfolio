document.addEventListener('DOMContentLoaded', () => {
    // Limpia el parámetro timeout de la URL
    setTimeout(() => {
        const url = new URL(window.location.href);
        url.searchParams.delete('timeout');
        const cleanUrl = url.pathname + (url.search ? '?' + url.search : '') + url.hash;
        window.history.replaceState({}, document.title, cleanUrl);
    }, 3000);
});