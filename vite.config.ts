import tailwindcss from '@tailwindcss/vite'
import react from '@vitejs/plugin-react'
import laravel from 'laravel-vite-plugin'
import { resolve } from 'node:path'
import { defineConfig } from 'vite'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/ts/app.tsx'],
            ssr: 'resources/ts/ssr.tsx',
            refresh: true
        }),
        react(),
        tailwindcss()
    ],
    esbuild: {
        jsx: 'automatic'
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/ts'),
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy')
        }
    }
})
