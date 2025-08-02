window.addEventListener('DOMContentLoaded', event => {

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    const datatablesSimple2 = document.getElementById('tableB');
    if (datatablesSimple2) {
        new simpleDatatables.DataTable(datatablesSimple2);
    }
});