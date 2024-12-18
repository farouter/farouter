import Input from "../Input";

export default function Text({ value, ...args }) {
  return <Input type="text" value={value} {...args} />;
}
