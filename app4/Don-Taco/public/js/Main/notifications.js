document.addEventListener('DOMContentLoaded', function () {
    window.latestChatCount = 0;
    window.latestNotifCount = 0;

    loadNotifications();

    // Set polling interval once
    setInterval(loadNotifications, 5000);

    const markAllBtn = document.querySelector('#notificationMenu .notification-header a');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function (e) {
            e.preventDefault();
            fetch('notification/markAllAsRead', { method: 'POST' })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        loadNotifications();
                    }
                });
        });
    }

    const toggleBtn = document.getElementById('toggleSeenBtn');
    const seenSection = document.getElementById('seenNotifications');

    if (toggleBtn && seenSection) {
        toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const isVisible = seenSection.style.display === 'block';
            seenSection.style.display = isVisible ? 'none' : 'block';
            toggleBtn.textContent = isVisible
                ? 'Ver todas las notificaciones'
                : 'Ocultar notificaciones vistas';
        });
    }
});

function loadNotifications() {
    fetch('notification/fetchGlobal')
        .then(res => res.json())
        .then(notifications => {
            const unreadList = document.getElementById('unreadList') || document.querySelector('.notification-section ul.notification-list');
            const seenList = document.getElementById('seenList');

            if (!unreadList || !seenList) return;

            unreadList.innerHTML = '';
            seenList.innerHTML = '';

            const unread = notifications.filter(n => n.is_read == 0);
            const seen = notifications.filter(n => n.is_read == 1);

            if (unread.length === 0) {
                unreadList.innerHTML = '<li class="notification-item">No hay notificaciones nuevas</li>';
            } else {
                unread.forEach(n => {
                    unreadList.appendChild(createNotificationItem(n, true));
                });
            }

            if (seen.length === 0) {
                seenList.innerHTML = '<li class="notification-item">No hay notificaciones leídas</li>';
            } else {
                seen.forEach(n => {
                    seenList.appendChild(createNotificationItem(n, false));
                });
            }

            updateBadge(unread.length);
        });
}

function createNotificationItem(n, isUnread) {
    const item = document.createElement('li');
    item.className = 'notification-item' + (isUnread ? ' unread' : '');

    item.innerHTML = `
        <i class="fa fa-comment icon"></i>
        <div class="content">
            <strong>${n.username || 'Sistema'}</strong> ${n.title}<br>
            <small>${timeAgo(n.created_at)}</small>
            ${n.link ? `<div><a href="${n.link}" class="notification-link">Ver cambios</a></div>` : ''}
        </div>
    `;

    return item;
}

function updateGlobalBadge() {
    const global = document.getElementById('globalBadge');
    if (!global) return;

    const total = window.latestChatCount + window.latestNotifCount;
    global.textContent = total;
    global.style.display = total > 0 ? 'inline-block' : 'none';
}

function updateBadge(count) {
    window.latestNotifCount = count;
    updateGlobalBadge(); // Call shared badge update
}

function timeAgo(timestamp) {
    const now = new Date();
    const then = new Date(timestamp);
    const seconds = Math.floor((now - then) / 1000);

    if (seconds < 60) return 'Justo ahora';
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes} min${minutes !== 1 ? 's' : ''} atrás`;
    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours} hora${hours !== 1 ? 's' : ''} atrás`;
    const days = Math.floor(hours / 24);
    return `${days} día${days !== 1 ? 's' : ''} atrás`;
}
