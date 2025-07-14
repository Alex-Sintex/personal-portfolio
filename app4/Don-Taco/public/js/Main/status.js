// Initialize the Toasty library
const toast = new Toasty();

document.querySelectorAll('.status-option').forEach(item => {
    item.addEventListener('click', function () {
        const status = this.getAttribute('data-status');

        // Update label and icon instantly
        const label = document.getElementById('status-label');
        const icon = document.getElementById('status-icon');

        const statusMap = {
            online: { text: 'Online', color: '#198754' },
            busy: { text: 'Busy', color: '#ffc107' },
            offline: { text: 'Offline', color: '#dc3545' }
        };

        label.textContent = statusMap[status].text;
        icon.style.color = statusMap[status].color;

        // Send status to server
        fetch('account/update_status', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    toast.info(`Estado actualizado a: ${statusMap[status].text}`);
                } else {
                    toast.error(`Error: ${data.message}`);
                }
            })
            .catch(err => {
                console.error(err);
                toast.error('Ocurrió un error al actualizar el estatus.');
            });
    });
});