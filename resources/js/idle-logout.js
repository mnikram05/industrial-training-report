/**
 * Log out the user after a period of browser idle time (no input).
 * Uses the same duration as config session lifetime (meta idle-auto-logout-minutes).
 */
export function initIdleAutoLogout() {
    const meta = document.querySelector('meta[name="idle-auto-logout-minutes"]');
    if (!meta) {
        return;
    }

    const minutes = parseInt(meta.getAttribute('content') ?? '', 10);
    if (!Number.isFinite(minutes) || minutes <= 0) {
        return;
    }

    const logoutUrl = document.querySelector('meta[name="logout-url"]')?.getAttribute('content');
    if (!logoutUrl) {
        return;
    }

    const ms = minutes * 60 * 1000;
    let idleTimer = null;

    const logout = () => {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = logoutUrl;
        if (token) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_token';
            input.value = token;
            form.appendChild(input);
        }
        document.body.appendChild(form);
        form.submit();
    };

    const bumpIdleTimer = () => {
        if (idleTimer !== null) {
            clearTimeout(idleTimer);
        }
        idleTimer = window.setTimeout(logout, ms);
    };

    let rafScheduled = false;
    const onActivity = () => {
        if (rafScheduled) {
            return;
        }
        rafScheduled = true;
        requestAnimationFrame(() => {
            rafScheduled = false;
            bumpIdleTimer();
        });
    };

    bumpIdleTimer();

    const events = ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll', 'wheel', 'click'];
    events.forEach((eventName) => {
        window.addEventListener(eventName, onActivity, { passive: true });
    });
}
