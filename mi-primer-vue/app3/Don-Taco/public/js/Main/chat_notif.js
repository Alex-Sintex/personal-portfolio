document.addEventListener('DOMContentLoaded', function () {
    window.latestChatCount = 0;
    window.latestNotifCount = 0;
    loadChatNotifications(); // Initial load
    setInterval(loadChatNotifications, 5000); // Auto-refresh every 5s
});

function loadChatNotifications() {
    fetch('chat/fetchUnread')
        .then(response => response.json())
        .then(data => {
            if (!Array.isArray(data)) return;

            const totalUnread = data.reduce((acc, item) => acc + parseInt(item.unread_count || 0), 0);
            updateChatBadge(totalUnread);
            populateChatDropdown(data);
        })
        .catch(err => {
            console.error("Error loading chat notifications:", err);
        });
}

function updateGlobalBadge() {
    const global = document.getElementById('globalBadge');
    if (!global) return;

    const total = window.latestChatCount + window.latestNotifCount;
    global.textContent = total;
    global.style.display = total > 0 ? 'inline-block' : 'none';
}

function updateChatBadge(count) {
    window.latestChatCount = count;
    updateGlobalBadge(); // Call shared badge update
}

function populateChatDropdown(messages) {
    const chatContainer = document.getElementById('chatNotificationList');
    if (!chatContainer) return;

    chatContainer.innerHTML = '';

    if (messages.length === 0) {
        chatContainer.innerHTML = '<li class="notification-item">No hay mensajes nuevos</li>';
        return;
    }

    messages.forEach(msg => {
        const li = document.createElement('li');
        li.className = 'notification-item unread chat-notification';
        li.innerHTML = `
            <i class="fa fa-envelope icon"></i>
            <div class="content">
                <strong>${msg.sender_username}</strong><br>
                <small>${truncate(msg.last_message || '', 50)}</small><br>
                <small>${timeAgo(msg.last_message_time)}</small><br>
                <a href="chat?user=${msg.sender_id}" class="notification-link" data-sender-id="${msg.sender_id}">Responder</a>
            </div>
        `;

        // Add click event to mark messages as read
        li.querySelector('.notification-link').addEventListener('click', function (e) {
            const senderId = this.dataset.senderId;

            fetch('chat/markAsRead', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ sender_id: senderId })
            });

            // Optimistically update UI
            li.remove();
            const remaining = document.querySelectorAll('.chat-notification').length;
            updateChatBadge(remaining);
        });

        chatContainer.appendChild(li);
    });
}

function truncate(text, maxLength) {
    return text.length > maxLength ? text.substring(0, maxLength) + '…' : text;
}

function timeAgo(datetime) {
    const time = new Date(datetime);
    const now = new Date();
    const seconds = Math.floor((now - time) / 1000);

    const intervals = [
        { label: 'año', seconds: 31536000 },
        { label: 'mes', seconds: 2592000 },
        { label: 'día', seconds: 86400 },
        { label: 'hora', seconds: 3600 },
        { label: 'minuto', seconds: 60 },
        { label: 'segundo', seconds: 1 }
    ];

    for (const interval of intervals) {
        const count = Math.floor(seconds / interval.seconds);
        if (count >= 1) {
            return `hace ${count} ${interval.label}${count > 1 ? 's' : ''}`;
        }
    }

    return 'justo ahora';
}
