import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
  build: {
    // Agar Vite tidak mencari index.html default
    rollupOptions: {
      input: 'resources/css/style.css',
      output: {
        // Hapus hashing (biar file tetap bernama style.css)
        assetFileNames: 'assets/[name].[ext]'
      }
    },
    outDir: 'public/build', // Dimana output file build diletakan
    emptyOutDir: true,
  }
})