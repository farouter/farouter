import Form, { useForm } from "@/Components/Form";

export default function Create({ node, resource, nodeableType }) {
  const getInitialData = (fields) => {
    return fields.reduce((acc, field) => {
      acc[field.attribute] = field.value || "";
      return acc;
    }, {});
  };
  const form = useForm("post", route("farouter::nodes.store", { node: node.data, nodeableType: nodeableType }), getInitialData(resource.fields));

  return (
    <div className="">
      <div>Parent node: {node.data.resource.title}</div>
      <Form formRef={form}>
        {resource.fields.map((field, key) => (
          <Form.Field key={key} mode="form" field={field} name={field.attribute} />
        ))}

        <Form.Submit>Create</Form.Submit>
      </Form>
    </div>
  );
}
