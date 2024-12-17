import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      hotFile: "public/dist/vite.hot",
      buildDirectory: "dist/build",
      input: ["resources/css/app.css", "resources/js/app.jsx"],
      refresh: true,
    }),
    react(),
  ],
});
