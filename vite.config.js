import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/bootstrap.css',
                'resources/js/bootstrap.bundle.js',
                'resources/css/sticky-footer-navbar.css',
                'resources/css/signin.css',
                'resources/css/form-validation.css',
                'resources/js/form-validation.js',
                'resources/js/clients.js'
            ],
            refresh: true,
        }),
    ],
});
