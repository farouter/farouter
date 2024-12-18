import { useEffect } from "react";
import Form, { useForm } from "../../Components/Form";
import { ResolveField } from "@/Components/Fields";
import { Link } from "@inertiajs/react";
import Panel from "@/Components/Panel";

export default function Edit({ node, children }) {
  const getInitialData = (fields) => {
    return fields.reduce((acc, field) => {
      acc[field.attribute] = field.value || "";
      return acc;
    }, {});
  };

  console.log("node", node);

  const form = useForm("patch", route("farouter::nodes.update", { node: node.data }), getInitialData(node.data.resource.fields));

  return (
    <div className="flex flex-col gap-4">
      <Panel title={`Editing ${node.data.resource.title}`}>
        <Form formRef={form}>
          {node.data.resource.fields.map((field, key) => (
            <Form.Field key={key} mode="form" field={field} name={field.attribute} />
          ))}

          <Form.Submit>Save</Form.Submit>
        </Form>
      </Panel>

      <Panel title="Create">
        {node.data.resource.dependencies.map((dependency, key) => (
          <div key={key}>
            <Link href={route("farouter::nodes.create", { node: node.data, nodeableType: dependency })}>Create {dependency}</Link>
          </div>
        ))}
      </Panel>

      <div>Children</div>
      <table>
        <tbody>
          {children.data.map((child, key) => (
            <tr key={key}>
              {child.resource.fields.map((field, key) => (
                <td key={key}>
                  <ResolveField mode="index" field={field} value={field.value} />
                </td>
              ))}

              <td>
                <Link href={route("farouter::nodes.edit", { node: child })}>Edit</Link>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
