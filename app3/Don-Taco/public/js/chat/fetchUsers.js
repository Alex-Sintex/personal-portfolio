document.addEventListener('DOMContentLoaded', () => {
    fetchUsersAndDisplay();
    setInterval(fetchUsersAndDisplay, 10000); // Auto-refresh every 10s
});

function fetchUsersAndDisplay() {
    fetch('chat/getUsersStatus')
        .then(response => {
            if (!response.ok) throw new Error('Error fetching users');
            return response.json();
        })
        .then(data => {
            renderUsers('Online', data.online);
            renderUsers('Offline', data.offline);
        })
        .catch(error => {
            console.error('Error fetching users:', error);
        });
}

function capitalizeFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function renderUsers(tabId, users) {
    const container = document.getElementById(tabId);
    if (!container) {
        console.warn(`No container found for tab: ${tabId}`);
        return;
    }

    container.innerHTML = ''; // Clean old content

    if (users.length === 0) {
        container.innerHTML = `<p class="text-muted">No ${tabId.toLowerCase()} users</p>`;
        return;
    }

    users.forEach(user => {
        const userElement = document.createElement('div');
        userElement.className = 'chat-user d-flex align-items-center p-2 border-bottom';

        userElement.innerHTML = `
            <img src="${user.avatar}" class="img-fluid" width="40" height="40" alt="${user.username}-img">
            <span class="${tabId === 'Online' ? 'active' : 'success'}"></span>
            <div class="flex-grow-1 ms-3">
                <h3>${capitalizeFirstLetter(user.username)}</h3>
                <p class="text-${tabId === 'Online' ? 'success' : 'secondary'}">${user.status}</p>
            </div>
        `;

        container.appendChild(userElement);
    });
}