// Notification Menu Toggle
document.querySelector('.notification-toggle').addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('notificationMenu').classList.toggle('show');
});

document.addEventListener('click', function (e) {
    const toggle = document.querySelector('.notification-toggle');
    const menu = document.getElementById('notificationMenu');
    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove('show');
    }
});
