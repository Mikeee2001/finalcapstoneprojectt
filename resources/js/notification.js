document.addEventListener('DOMContentLoaded', function () {

    const userId = document.querySelector('meta[name="user-id"]').content;
    const role = document.querySelector('meta[name="user-role"]').content;
    const badge = document.getElementById('notificationCount');
    const body = document.getElementById('notificationBody');

    // =========================
    // SAFE BADGE HANDLER
    // =========================
    function setBadge(count) {
        if (!badge) return;

        const safeCount = isNaN(count) ? 0 : count;

        badge.innerText = safeCount;
        badge.style.display = safeCount > 0 ? 'inline-block' : 'none';
    }

    // =========================
    // GET CURRENT COUNT FROM DB (SOURCE OF TRUTH)
    // =========================
    async function refreshBadge() {
        try {
            const res = await fetch('/notifications/unread-count', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await res.json();
            setBadge(data.count ?? 0);

        } catch (err) {
            console.error('Failed to fetch unread count:', err);
        }
    }

    // =========================
    // ADD NOTIFICATION UI
    // =========================
    function addNotification(data) {
        if (!body) return;

        body.insertAdjacentHTML('afterbegin', `
            <div class="notification-item px-3 py-2 border-bottom">
                <div class="fw-semibold text-dark small">
                    ${data.action ?? 'Notification'}
                </div>
                <div class="text-muted small mt-1">
                    ${data.message ?? ''}
                </div>
            </div>
        `);
    }

    // =========================
    // REALTIME LISTENERS
    // =========================
    window.Echo.private(`notifications.${userId}`)
        .listen('.notification.created', (e) => {
            addNotification(e);
            refreshBadge(); // ✅ always sync instead of +1
        });

    window.Echo.private(`notifications.role.${role}`)
        .listen('.notification.created', (e) => {
            addNotification(e);
            refreshBadge(); // ✅ prevents double counting bugs
        });

    // =========================
    // AUTO MARK AS READ WHEN DROPDOWN OPENS
    // =========================
    const dropdownToggle = document.querySelector('[data-bs-toggle="dropdown"]');

    if (dropdownToggle) {
        dropdownToggle.addEventListener('click', async () => {

            try {
                await fetch('/notifications/mark-as-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });

                setBadge(0); // instantly clear UI
            } catch (err) {
                console.error('Mark as read failed:', err);
            }
        });
    }

    // =========================
    // INITIAL LOAD
    // =========================
    refreshBadge();

});
