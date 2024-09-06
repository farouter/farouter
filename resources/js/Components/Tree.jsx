import Icon from "../Icons";

const Item = function ({ title, children = null }) {
  return (
    <li className="pl-5">
      <div className=" group">
        <a href="#" className="flex items-center gap-1 py-[2px] h-5 relative z-20">
          {children && (
            <div>
              <Icon name="ChevronDown" />
            </div>
          )}

          <div className={`${!children && "pl-2"}`}>
            <Icon name={children ? "Folder" : "File"} />
          </div>
          <div>{title}</div>
        </a>
        <div className="absolute left-0 w-full h-5 -translate-y-5 z-10 bg-gray-700/75 hidden group-hover:block"></div>
      </div>

      {children && <ul>{children}</ul>}
    </li>
  );
};

const Tree = function () {
  return (
    <ul className="text-sm relative *:pl-2 text-gray-300">
      <Item title="Home Page">
        <Item title="About as">
          <Item title="Idea" />
          <Item title="Our perfomance" />
          <Item title="Contact information" />
          <Item title="Social networks" />
        </Item>
        <Item title="Services" />
        <Item title="Adwantages" />
        <Item title="Products">
          <Item title="First product" />
          <Item title="Second product" />
        </Item>
        <Item title="Articles">
          <Item title="Base articles" />
          <Item title="General articles" />
          <Item title="Articles by theme">
            <Item title="Around the world" />
            <Item title="Trawel and feet by it" />
          </Item>
        </Item>
        <Item title="Albums">
          <Item title="First album" />
          <Item title="My own photos" />
          <Item title="Images from Instagram" />
        </Item>
        <Item title="Users" />
        <Item title="Comments" />
        <Item title="Deployments" />
        <Item title="Cities" />
      </Item>
    </ul>
  );
};

export default Tree;
