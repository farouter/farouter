import { useEffect } from "react";
import Form, { useForm } from "../../Components/Form";
import { ResolveField } from "@/Components/Fields";
import { Link } from "@inertiajs/react";

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
    <div className="bg-gray-300">
      <div>The title: {node.data.resource.title}</div>
      <Form formRef={form}>
        {node.data.resource.fields.map((field, key) => (
          <Form.Field key={key} mode="form" field={field} name={field.attribute} />
        ))}

        <Form.Submit>Save</Form.Submit>
      </Form>

      <div>
        <div>CREATE</div>
        <div>
          {node.data.resource.dependencies.map((dependency, key) => (
            <Link key={key} href={route("farouter::nodes.create", { node: node.data, nodeableType: dependency })}>
              Create {dependency}
            </Link>
          ))}
        </div>
      </div>

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
