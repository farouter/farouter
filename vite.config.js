import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      hotFile: "public/vendor/farouter/farouter.hot",
      buildDirectory: "vendor/farouter",
      input: ["resources/css/app.css", "resources/js/app.jsx"],
      refresh: true,
    }),
  ],
});
