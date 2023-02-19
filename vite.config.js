import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import dotenv from "dotenv";
dotenv.config();

export default defineConfig({
    plugins: [
        vue({
            template: {
                compilerOptions: {
                    compatConfig: {
                        MODE: 3,
                    },
                },
            },
        }),
        laravel({
            input: [
                "resources/assets/css/app.css",
                "resources/assets/js/app.js",
            ],
            refresh: true,
        }),
    ],
    define: {
        "process.env": process.env,
    },
});
