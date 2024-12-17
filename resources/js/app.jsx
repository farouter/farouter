import { createInertiaApp } from "@inertiajs/react";
import React from "react";
import { createRoot } from "react-dom/client";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import Authorized from "./Layouts/Authorized";

createInertiaApp({
  resolve: (name) => {
    const page = resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob("./Pages/**/*.jsx"));

    page.then((module) => {
      module.default.layout = module.default.layout || ((page) => <Authorized children={page} />);
    });

    return page;
  },
  setup({ el, App, props }) {
    el.classList.add("h-full");

    const root = createRoot(el);

    root.render(<App {...props} />);
  },
  progress: {
    color: "#4B5563",
  },
});
