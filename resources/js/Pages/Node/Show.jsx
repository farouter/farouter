import Field from "../../Fields";

const Show = ({ node }) => {
  console.log("node", node);
  return (
    <div>
      <h1 className="text-3xl font-bold underline">Hello world!</h1>
      <p>/{node.data.path}</p>
      <div>
        {node.data.resource.fields.map((field, key) => (
          <Field key={key} name={field.component} field={field} />
        ))}
      </div>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint, laudantium obcaecati! Iure voluptate sed ratione nihil hic expedita cupiditate quisquam dignissimos natus reiciendis, quo, architecto, beatae cum repudiandae quia adipisci.</p>
    </div>
  );
};

// Show.layout = (page) => <Guest children={page} />;

export default Show;
