import React from "react";
import Text from "./Text";

export { Text };

export default function Field({ name, ...attributes }) {
  const names = {
    "text-field": Text,
  };

  return React.createElement(names[name], { ...attributes });
}
