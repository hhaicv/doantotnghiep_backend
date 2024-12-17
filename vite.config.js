import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/sass/app.scss",
                "resources/js/public.js",
                "resources/js/private.js",
                "resources/js/present.js",
            ],
            refresh: true,
        }),
    ],
});