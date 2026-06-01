import './bootstrap';
import './notification';

const userId = document.head.querySelector('meta[name="user-id"]').content;

window.Echo.private(`notifications.${userId}`)
    .listen('.notification.created', (e) => {

        console.log('New notification:', e);

        let badge = document.getElementById('notificationCount');

        if (badge) {
            badge.innerText = parseInt(badge.innerText || 0) + 1;
            badge.style.display = 'inline-block';
        }

    });
