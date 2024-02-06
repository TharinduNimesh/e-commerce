<script setup>
defineProps({
  is_open: Boolean,
});

const nav_items = [
  {
    path: "/app/dashboard",
    icon: "solar:chart-bold",
    name: "Dashboard",
  },
  {
    path: "/app/comics",
    icon: "solar:notebook-bookmark-bold",
    name: "Comics",
  },
  {
    path: "/app/issuers",
    icon: "simple-icons:dcentertainment",
    name: "Issuers",
  },
  {
    path: "/app/categories",
    icon: "solar:widget-add-bold",
    name: "Categories",
  },
  {
    path: "/app/users",
    icon: "bx:bxs-user-account",
    name: "Users",
  },
];

function isActive(current_route, item_route) {
  if (current_route.includes(item_route)) {
    return true;
  }
  return false;
}
</script>

<template>
  <div
    class="w-[280px] absolute lg:relative h-full bg-primary-light dark:bg-primary-dark rounded-r-lg transition-[margin] duration-300 overflow-hidden overflow-y-scroll z-50"
    :class="{
      '-ml-[280px]': !is_open,
      'ml-0': is_open,
    }"
  >
    <div
      class="relative w-full lg:hidden z-50"
      :class="{
        hidden: !is_open,
      }"
    >
      <div
        class="absolute flex items-center justify-center -right-16 top-2 w-16 h-12 rounded-r-full bg-primary-light dark:bg-primary-dark cursor-pointer"
        @click="$emit('toggle-navbar')"
      >
        <Icon
          name="material-symbols:close-rounded"
          class="h-6 w-6 text-gray-400 dark:text-gray-500"
        />
      </div>
    </div>
    <div class="w-full flex flex-col px-3">
      <div class="flex items-center mt-5 gap-3">
        <img src="/img/logo.png" alt="ComicCage" class="h-16 rounded-full" />
        <div class="flex flex-col">
          <h1 class="text-2xl text-gray-700 dark:text-gray-200 font-bold">
            ComicCage
          </h1>
          <span
            class="text-gray-500 dark:slate-400 font-semibold uppercase text-xs"
          >
            Admin
          </span>
        </div>
      </div>
      <UDivider class="my-5" />
      <div class="flex flex-col gap-1">
        <AppNavbarItem
          v-for="item in nav_items"
          :key="item.path"
          :path="item.path"
          :icon="item.icon"
          :name="item.name"
          :is_active="isActive($route.fullPath, item.path)"
        />
      </div>
    </div>
  </div>
</template>
