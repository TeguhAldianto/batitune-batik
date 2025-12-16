import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Theme toggle: persist to localStorage and respect system preference
(function () {
    const THEME_KEY = 'batik_theme';
    const themeToggle = document.getElementById('theme-toggle');

    const setTheme = (mode) => {
        if (mode === 'dark') {
            document.documentElement.classList.add('dark');
            localStorage.setItem(THEME_KEY, 'dark');
        } else if (mode === 'light') {
            document.documentElement.classList.remove('dark');
            localStorage.setItem(THEME_KEY, 'light');
        }
    };

    // Initialize
    const saved = localStorage.getItem(THEME_KEY);
    if (saved === 'dark' || (!saved && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    // Toggle handler
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
            // Optional: dispatch event for other components
            window.dispatchEvent(new CustomEvent('theme:changed', { detail: { dark: isDark } }));
        });
    }
})();
