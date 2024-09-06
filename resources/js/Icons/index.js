import React from "react";
import Search from "./Search";
import File from "./File";
import Folder from "./Folder";
import FolderOpen from "./FolderOpen";
import ChevronRight from "./ChevronRight";
import ChevronDown from "./ChevronDown";
import Structure from "./Structure";
import Gallery from "./Gallery";
import Storage from "./Storage";
import Notification from "./Notification";
import Settings from "./Settings";
import User from "./User";

export { Search, File, Folder, FolderOpen, ChevronRight, ChevronDown, Structure, Gallery, Storage, Notification, Settings, User };

export default function Icon({ name, className = null }) {
  const names = {
    Search: Search,
    File: File,
    Folder: Folder,
    FolderOpen: FolderOpen,
    ChevronRight: ChevronRight,
    ChevronDown: ChevronDown,
    Structure: Structure,
    Gallery: Gallery,
    Storage: Storage,
    Notification: Notification,
    Settings: Settings,
    User: User,
  };

  return React.createElement(names[name], { className: className });
}
