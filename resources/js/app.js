import './bootstrap';

import Alpine from 'alpinejs';
import jQuery from 'jquery';
import 'datatables.net-dt';
import './datatables';
import registerLandingPreview from './landing-preview';

window.Alpine = Alpine;
window.$ = window.jQuery = jQuery;

const storedTheme = localStorage.getItem('theme');
const initialTheme = storedTheme === 'dark' ? 'dark' : 'light';
const initialSidebarCollapsed = localStorage.getItem('sidebar:collapsed') === '1';

Alpine.store('layout', {
    theme: initialTheme,
    sidebarCollapsed: initialSidebarCollapsed,
    booted: false,

    boot() {
        if (this.booted) {
            return;
        }

        this.booted = true;
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
        this.sidebarCollapsed = !this.sidebarCollapsed;
        localStorage.setItem('sidebar:collapsed', this.sidebarCollapsed ? '1' : '0');
        this.applySidebarState();
    },
});

Alpine.store('layout').boot();
registerLandingPreview(Alpine);
Alpine.start();
