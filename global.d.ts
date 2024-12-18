import { PageProps as InertiaPageProps } from "@inertiajs/core";
import { AxiosInstance } from "axios";
import ziggyRoute, { Config as ZiggyConfig } from "ziggy";
import { PageProps as AppPageProps } from "./";
import { useTranslation } from "@/Hooks";

declare global {
  interface Window {
    axios: AxiosInstance;
  }

  var route: typeof ziggyRoute;
  var Ziggy: ZiggyConfig;
  var Echo;
  var dusk;
}

declare module "@inertiajs/core" {
  interface PageProps extends InertiaPageProps, AppPageProps {
    responseId;
    flash;
    nodes;
  }
}
