import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
  plugins: [
    vue(),
    VitePWA({
      registerType: 'autoUpdate',
      manifest: {
        name: 'Portafolio de Kevin Alexis',
        short_name: 'Portfolio',
        description: 'Mi portafolio web progresivo hecho con Vue 3 + Vite',
        theme_color: '#ffffff',
        background_color: '#ffffff',
        display: 'standalone',
        start_url: '/',
        icons: [
          { src: 'favicons/android-chrome-192x192.png', sizes: '192x192', type: 'image/png' },
          { src: 'favicons/android-chrome-512x512.png', sizes: '512x512', type: 'image/png' },
        ],
      },
      workbox: {
        // Full offline support
        runtimeCaching: [
          // 1️⃣ Cache all static assets (JS, CSS, HTML, images, fonts)
          {
            urlPattern: /.*\.(js|css|html|png|svg|ico|json|woff2?)$/,
            handler: 'CacheFirst',
            options: {
              cacheName: 'static-assets-cache',
              expiration: {
                maxEntries: 100,
                maxAgeSeconds: 60 * 60 * 24 * 30, // 30 days
              },
            },
          },
          // 2️⃣ Cache your domain content / API (NetworkFirst)
          {
            urlPattern: /^https:\/\/kevin-alexis-portfolio\.netlify\.app\/.*$/,
            handler: 'NetworkFirst',
            options: {
              cacheName: 'api-cache',
            },
          },
        ],
      },
    }),
  ],
  resolve: {
    alias: {
      // Now you can use @/ to point to /src
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  build: {
    sourcemap: true, // Optional: helps debug production builds
  },
})
