export default function Panel({ title, children }) {
  return (
    <div className="flex flex-col gap-3">
      <div className="text-lg dark:text-gray-300">{title}</div>
      <div className="bg-white dark:bg-gray-900/40 rounded-lg border border-slate-300/50 dark:border-gray-700/50 shadow-xs">{children}</div>
    </div>
  );
}
