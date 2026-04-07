import './bootstrap';

import { initIdleAutoLogout } from './idle-logout';

import Alpine from 'alpinejs';
import jQuery from 'jquery';
import 'datatables.net-dt';
import './datatables';
import './datatable-sort-reload';
import registerLandingPreview from './landing-preview';

window.Alpine = Alpine;
window.$ = window.jQuery = jQuery;

const storedTheme = localStorage.getItem('theme');
const initialTheme = storedTheme === 'dark' ? 'dark' : 'light';
Alpine.store('layout', {
    theme: initialTheme,
    sidebarCollapsed: false,
    booted: false,

    boot() {
        if (this.booted) {
            return;
        }

        this.booted = true;
        this.sidebarCollapsed = false;
        localStorage.removeItem('sidebar:collapsed');
        document.documentElement.classList.remove('sidebar-collapsed');
        this.applyTheme();
        this.applySidebarState();
    },

    applyTheme() {
        document.documentElement.classList.toggle('dark', this.theme === 'dark');
    },

    toggleTheme() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', this.theme);
        this.applyTheme();
    },

    applySidebarState() {
        document.documentElement.classList.toggle('sidebar-collapsed', this.sidebarCollapsed);
    },

    toggleSidebar() {
        /* Tiada butang sidebar; kekalkan sentiasa terbuka untuk elak UI tersekat. */
    },
});

Alpine.store('layout').boot();
registerLandingPreview(Alpine);
initIdleAutoLogout();

Alpine.data('adminHeaderClock', () => ({
    time: '',
    dateLine: '',
    timer: null,

    init() {
        const tick = () => {
            const d = new Date();
            const loc = document.documentElement.lang?.toLowerCase().startsWith('ms') ? 'ms-MY' : 'en-MY';
            this.time = d.toLocaleTimeString(loc, { hour: '2-digit', minute: '2-digit', hour12: false });
            this.dateLine = d.toLocaleDateString(loc, {
                weekday: 'short',
                month: 'short',
                day: 'numeric',
                year: 'numeric',
            });
        };
        tick();
        this.timer = setInterval(tick, 1000);
    },

    destroy() {
        if (this.timer) {
            clearInterval(this.timer);
        }
    },
}));

Alpine.start();
