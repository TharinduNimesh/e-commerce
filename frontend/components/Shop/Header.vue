<script setup>
const color = useColorMode().preference;
const is_dark = ref(color === "dark");

// watch for color mode changes
watch(
  () => useColorMode().preference,
  (value) => {
    is_dark.value = value === "dark";
  }
);

// watch for is_dark changes
watch(
  () => is_dark.value,
  (value) => {
    useColorMode().preference = value ? "dark" : "light";
  }
);

const paths = [
  {
    name: "Home",
    path: "/",
  },
  {
    name: "Category",
    path: "/category",
  },
  {
    name: "Latest",
    path: "/latest",
  },
  {
    name: "Support",
    path: "/support",
  },
];
</script>

<template>
  <header class="fixed w-full top-0 z-40 px-5 py-4">
    <div
      class="w-full px-5 py-2 h-14 bg-primary-light-transparent dark:bg-primary-dark-transparent rounded-lg shadow dark:shadow-black backdrop-blur-md"
    >
      <div class="w-full grid grid-cols-3">
        <div class="hidden lg:flex items-center gap-5">
          <NuxtLink
            v-for="path in paths"
            :key="path.name"
            :to="path.path"
            class="duration-300"
            :class="{
              'text-blue-500 dark:text-blue-700': path.path === $route.path,
              'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-100':
                path.path !== $route.path,
            }"
          >
            {{ path.name }}
          </NuxtLink>
        </div>
        <div class="col-span-2 lg:col-span-1 flex lg:justify-center items-center gap-4">
          <img src="/img/logo.png" class="w-10" alt="Logo of GameHeaven" />
          <h1>
            <span
              class="text-2xl float-left font-bold text-gray-800 dark:text-slate-100"
            >
              Game
            </span>
            <span
              class="text-2xl float-left font-bold text-gradient from-violet-600 to-blue-400"
            >
              Heaven
            </span>
            <span>
              <span
                class="text-2xl float-left font-bold text-blue-500 dark:text-blue-700"
              >
                .
              </span>
            </span>
          </h1>
        </div>
        <div class="hidden lg:flex justify-end items-center gap-5">
          <UTooltip text="Toggle Theme" :shortcuts="['Ctrl', 'Enter']">
            <UToggle
              class="dark:bg-[#23232499]"
              on-icon="i-heroicons-moon"
              off-icon="i-heroicons-sun"
              v-model="is_dark"
            />
          </UTooltip>

          <div
            class="w-9 h-9 rounded shadow-md flex justify-center items-center hover:bg-gray-100 dark:hover:bg-[#232324aa] cursor-pointer duration-300"
          >
            <Icon
              name="material-symbols:search"
              class="text-lg dark:text-gray-400"
            />
          </div>
          <div class="flex gap-2">
            <UButton
              size="md"
              color="gray"
              varient="solid"
              label="SIGN UP"
              to="/register"
            />
            <UButton
              size="md"
              color="black"
              varient="solid"
              label="SIGN IN"
              to="/login"
            />
          </div>
        </div>
      </div>
    </div>
  </header>
</template>