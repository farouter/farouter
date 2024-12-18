import { Link, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";

// Рекурсивний компонент для дерева вузлів
const NodeTree = ({ nodes }) => {
  if (!nodes || nodes.length === 0) return null;

  return (
    <ul>
      {nodes.map((node) => (
        <li key={node.id}>
          <Link href={route("farouter::nodes.edit", { node: node })}>{node.resource.title}</Link>
          {node.children && <NodeTree nodes={node.children} />}
        </li>
      ))}
    </ul>
  );
};

export default function Authorized({ children }) {
  const { flash = {}, nodes } = usePage().props;

  const [message, setMessage] = useState(null);

  useEffect(() => {
    if (flash.success) {
      setMessage(flash.success);
    } else if (flash.error) {
      setMessage(flash.error);
    }

    // Автоматичне приховування через 3 секунди
    const timer = setTimeout(() => {
      setMessage(null);
    }, 3000);

    return () => clearTimeout(timer); // Очищення таймера при оновленні компонента
  }, [flash]);

  return (
    <div className="bg-gray-100 flex h-full relative">
      {message && <div className="absolute top-4 right-4 bg-gray-700 text-white">{message}</div>}
      <div className="w-48 shrink-0">
        <h3>Node Tree</h3>
        <NodeTree nodes={nodes.data} />
      </div>
      <div className="bg-gray-200 grow">{children}</div>
    </div>
  );
}
