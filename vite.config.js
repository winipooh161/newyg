import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
               
                'resources/js/app.js',
                'resources/css/style.css',
                'resources/css/adm.css',
                'resources/css/animate.css',
                'resources/css/mobile.css',
                'resources/css/mobile_adm.css',
            ],
            refresh: true,
        }),
    ],
    server: {
        cors: true,
    },
});
