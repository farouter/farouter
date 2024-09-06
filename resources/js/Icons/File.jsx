import { twMerge } from "tailwind-merge";

export default function ({ className = null }) {
  return (
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" className={twMerge("w-4 h-4", className)}>
      <path d="M13 9h5.5L13 3.5V9M6 2h8l6 6v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4c0-1.11.89-2 2-2m5 2H6v16h12v-9h-7V4z" fill="#90a4ae" />
    </svg>
  );
}
