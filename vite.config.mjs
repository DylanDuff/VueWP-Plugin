import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import tailwind from "@tailwindcss/vite";
import path from "path";

export default defineConfig({
  root: "./vue-src",
  plugins: [vue(), tailwind()],
  build: {
    outDir: path.resolve(__dirname, "dist"),
    emptyOutDir: true,
    rollupOptions: {
      input: path.resolve(__dirname, "vue-src/main.js"),
      output: {
        entryFileNames: "app.js",
        assetFileNames: "style.css",
      },
    },
  },
});
