<script setup>
const items = [
  {
    label: "Your Account",
    icon: "material-symbols:person-outline-rounded",
    path: "/app/settings",
  },
  {
    label: "Financials & Payments",
    icon: "material-symbols:credit-card-outline",
    path: "/app/settings/payments",
  },
  {
    label: "Preferences",
    icon: "material-symbols:brush-outline-sharp",
    path: "/app/settings/preferences",
  },
  {
    label: "Change Password",
    icon: "material-symbols:key-outline-rounded",
    path: "/app/settings/change-password",
  },
];
</script>

<template>
  <div>
    <NuxtLayout name="shop">
      <div class="flex justify-center pt-20">
        <div
          class="container flex flex-col md:flex-row items-center md:items-start pt-10 gap-4 px-5 sm:px-0"
        >
          <div
            class="w-full md:max-w-[300px] py-5 flex flex-col gap-1 bg-primary-light-transparent dark:bg-primary-dark-transparent shadow-lg rounded-lg dark:shadow-black"
          >
            <NuxtLink
              v-for="item in items"
              :key="item"
              :to="item.path"
              class="relative w-full h-10 flex items-center px-5"
              :class="{
                'text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300':
                  $route.path !== item.path,
                'text-violet-600 dark:text-violet-500':
                  $route.path === item.path,
              }"
            >
              <div
                v-if="$route.path === item.path"
                class="absolute w-1 h-full rounded-l bg-violet-600 dark:accent-violet-600"
              ></div>
              <Icon :name="item.icon" class="text-lg mx-3" />
              <span class="text-sm uppercase font-bold">{{ item.label }}</span>
            </NuxtLink>

            <div
              class="relative mt-3 w-full h-10 flex items-center px-5 text-red-500 hover:text-red-600 dark:hover:text-red-600 cursor-pointer"
            >
              <div
                class="absolute w-1 h-full rounded-l bg-red-600 dark:accent-red-600"
              ></div>
              <Icon
                name="material-symbols:power-settings-new-rounded"
                class="text-lg mx-3"
              />
              <span class="text-sm uppercase font-bold">Logout</span>
            </div>
          </div>
          <div class="flex-1 flex flex-col gap-8 pb-10">
            <slot />
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
