import Input from "../Input";

export default function ID({ value, ...args }) {
  return <Input type="text" value={value} {...args} />;
}
