import React from "react";
import IDForm from "./Form/ID";
import TextForm from "./Form/Text";

import IDIndex from "./Index/ID";
import TextIndex from "./Index/Text";

export function ResolveField({ mode, field, value, ...args }) {
  const fields = {
    index: {
      "id-field": IDIndex,
      "text-field": TextIndex,
    },
    form: {
      "id-field": IDForm,
      "text-field": TextForm,
    },
  };

  return React.createElement(fields[mode][field.component], { value: value, ...args });
}
