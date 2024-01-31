<script setup>
// const user = await useAuth();

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
  {
    label: "Logout",
    icon: "material-symbols:power-settings-new-rounded",
    path: "/app/settings/logout",
  },
];
</script>

<template>
  <NuxtLayout name="shop">
    <div class="flex justify-center pt-20">
      <div class="container flex pt-10">
        <div
          class="w-[300px] py-5 flex flex-col gap-1 bg-primary-light-transparent dark:bg-primary-dark-transparent shadow-lg rounded-lg dark:shadow-black"
        >
          <NuxtLink
            v-for="item in items"
            :key="item"
            :to="item.path"
            class="relative w-full h-10 flex items-center px-5"
            :class="{
              'text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300':
                $route.path !== item.path,
              'text-violet-600 dark:text-violet-500': $route.path === item.path,
            }"
          >
            <div
              v-if="$route.path === item.path"
              class="absolute w-1 h-full rounded-l bg-violet-600 dark:accent-violet-600"
            ></div>
            <Icon :name="item.icon" class="text-lg mx-3" />
            <span class="text-sm uppercase font-bold">{{ item.label }}</span>
          </NuxtLink>
        </div>
        <div class="flex-1"></div>
      </div>
    </div>
  </NuxtLayout>
</template>

<!-- <style scoped>
.active {
  @apply;
}
</style> -->
