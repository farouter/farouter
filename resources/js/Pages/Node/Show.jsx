import Guest from "../../Layouts/Guest";

const Show = () => {
  return (
    <div>
      <h1>Hwllo</h1>
    </div>
  );
};

Show.layout = (page) => <Guest children={page} />;

export default Show;
