export default defineAppConfig({
  ui: {
    primary: "indigo",
    gray: "cool",
    icons: {
      dynamic: true,
    },
    button: {
      default: {
        size: "md",
      },
      base: "uppercase text-xs font-bold",
      font: "",
    },
    input: {
      default: {
        size: "lg",
      },
      color: {
        gray: {
          outline: "dark:bg-[#2b2a33]",
        },
      },
    },
    select: {
      default: {
        size: "lg",
      },
      color: {
        gray: {
          outline: "dark:bg-[#2b2a33]",
        },
      },
    },
    dropdown: {
      background: "dark:bg-primary-dark",
      item: {
        base: "dark:hover:bg-secondary-dark/30",
      },
    },
    table: {
      th: {
        base: "whitespace-nowrap",
      },
      td: {
        base: "w-fit"
      },
      default: {
        sortButton: {
          class: "dark:hover:bg-secondary-dark/30",
        },
      },
    },
  },
});
