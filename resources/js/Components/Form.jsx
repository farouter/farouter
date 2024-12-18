import { createContext, useContext } from "react";
import { usePage } from "@inertiajs/react";
import { useForm } from "laravel-precognition-react-inertia";
import { twMerge } from "tailwind-merge";
import { ResolveField } from "../Components/Fields";

const FormContext = createContext(null);

const getDefaultFormId = () => {
  return usePage().props.currentRoute + "-form";
};

const Form = ({ formRef, id = null, onSuccess = () => {}, children, ...props }) => {
  if (id === null) {
    id = getDefaultFormId();
  }

  const onSubmit = (e) => {
    e.preventDefault();

    formRef.submit({
      preserveScroll: false,
      onSuccess: onSuccess,
    });
  };

  return (
    <FormContext.Provider value={{ formRef }}>
      <form onSubmit={onSubmit} id={id} {...props}>
        {children}
      </form>
    </FormContext.Provider>
  );
};

const Error = ({ className = null, children }) => {
  return <div className={twMerge("my-1 text-sm text-red-500", className)}>{children}</div>;
};

const Field = ({ mode, field, name, formRef = null, ...args }) => {
  if (formRef === null) {
    formRef = useContext(FormContext).formRef;
  }

  return (
    <div className="grid grid-cols-12 gap-3 border-b dark:border-gray-700/50 py-4">
      <div className="col-span-3 pl-4">{field.name}</div>
      <div className="col-span-6">
        <ResolveField mode={mode} field={field} value={formRef.data[name]} onChange={(e) => formRef.setData(name, e.target.value).forgetError(name)} onBlur={() => formRef.validate(name)} {...args} />
        {formRef.invalid(name) && <Error>{formRef.errors[name]}</Error>}
      </div>
    </div>
  );
};

const Submit = ({ disabled = false, form = null, className = null, children, ...props }) => {
  if (form === null) {
    form = getDefaultFormId();
  }
  return (
    <button type="submit" disabled={disabled} form={form} className={twMerge("group", className)} {...props}>
      {children}
    </button>
  );
};

Form.Field = Field;
Form.Submit = Submit;

export default Form;

export { useForm };
