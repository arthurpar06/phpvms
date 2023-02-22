import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/admin/paper-dashboard.scss',
                'resources/sass/now-ui/now-ui-kit.scss',
                'resources/js/admin/app.js',
                'resources/js/frontend/app.js',
                'resources/js/installer/app.js',
            ],
            refresh: true,
        }),
    ],
});
