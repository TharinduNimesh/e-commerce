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
        loadingIcon: "mingcute:loading-3-fill",
      },
      base: "uppercase text-xs font-bold",
      font: "",
    },
    input: {
      default: {
        size: "lg",
        color: "gray",
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
        color: "gray",
      },
      color: {
        gray: {
          outline: "dark:bg-[#2b2a33]",
        },
      },
    },
    textarea: {
      default: {
        size: "lg",
        color: "gray",
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
        base: "w-fit",
      },
      default: {
        sortButton: {
          class: "dark:hover:bg-secondary-dark/30",
        },
      },
    },
    selectMenu: {
      background: "dark:bg-[#2b2a33]",
      input: "dark:bg-[#2b2a33]",
      option: {
        color: "dark:bg-[#2b2a33] dark:hover:bg-[#3a3943]",
        selected: "dark:bg-primary-dark",
      },
    },
    slideover: {
      overlay: {
        background: "dark:bg-primary-dark/60",
      },
      background: "dark:bg-primary-dark",
    },
  },
});
