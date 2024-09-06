import { useState } from "react";
import { Dialog, DialogBackdrop, DialogPanel, Menu, MenuButton, MenuItem, MenuItems, TransitionChild } from "@headlessui/react";
import Icon, { Search } from "../Icons";
import Tree from "../Components/Tree";

const NavButton = ({ icon, active = false }) => {
  return (
    <a href="#" className={`w-12 h-12 flex items-center justify-center hover:text-gray-400 relative ${active ? "text-gray-400" : "text-gray-500"}`}>
      {active && <div className="absolute w-[2px] h-12 left-0 top-0 bg-gray-400"></div>}
      <Icon name={icon} className="w-7 h-7" />
    </a>
  );
};

export default function ({ children }) {
  const [sidebarOpen, setSidebarOpen] = useState(false);

  return (
    <div className="flex h-screen bg-gray-800 text-gray-400">
      <div className="w-12 flex flex-col shrink-0 justify-between items-start">
        <div>
          <NavButton icon="Structure" active={true} />
          <NavButton icon="Gallery" active={false} />
          <NavButton icon="Storage" active={false} />
        </div>
        <div>
          <NavButton icon="Notification" active={false} />
          <NavButton icon="Settings" active={false} />
          <NavButton icon="User" active={false} />
        </div>
      </div>
      <div className="w-72 flex flex-col gap-5 py-5 overflow-auto shrink-0 bg-gray-900/50">
        <div className="text-xs uppercase pl-5">Explorer</div>
        <Tree />
      </div>
      <div className="grow overflow-auto">
        <div className="border-b border-gray-700 flex items-center gap-5 sticky top-0 bg-gray-800 shadow-sm">
          <div className="grow pl-5">
            <div className="h-12 relative">
              <div className="absolute left-0 top-0 h-full flex items-center">
                <Search className="w-5 h-5 text-gray-500" />
              </div>
              <input type="text" className="absolute left-0 top-0 w-full h-full px-10 text-sm" placeholder="Search..." />
            </div>
          </div>
          <div className="divide-x flex shrink-0">
            <div className="px-5">ds</div>
            <div className="px-5">ds</div>
          </div>
        </div>
        <div className="p-5">{children}</div>
      </div>
    </div>
  );
}
