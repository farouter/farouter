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
    <div className="flex h-full relative bg-slate-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
      {message && <div className="absolute top-4 right-4 dark:bg-gray-700 text-white">{message}</div>}
      <div className="w-72 shrink-0 bg-white dark:bg-gray-900/40 border-r border-slate-300/50 dark:border-gray-700/50">
        <h3>Node Tree</h3>
        <NodeTree nodes={nodes.data} />
      </div>
      <div className="grow">
        <div className="py-4 px-6 border-b bg-white dark:bg-transparent dark:border-gray-700/50 flex">
          <div className="bg-slate-100 dark:bg-gray-700/50 border border-slate-300/50 dark:border-gray-600/50 text-sm rounded-lg h-8 px-3 w-full max-w-lg flex items-center cursor-pointer">Search...</div>
        </div>
        <div className="py-4 px-6">{children}</div>
      </div>
    </div>
  );
}
