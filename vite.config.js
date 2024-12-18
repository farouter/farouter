import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
  resolve: {
    alias: {
      "@farouter": path.resolve(__dirname, "./resources/js"),
    },
  },
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
