export default function ({ field }) {
  return (
    <label className="grid grid-cols-4">
      <span className="col-span-1">{field.name}</span>
      <input type="text" value={field.value} placeholder={field.placeholder} />
    </label>
  );
}
