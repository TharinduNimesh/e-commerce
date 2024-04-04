<script setup>
const color = useColorMode();
const router = useRouter();
const theme_icon = computed(() => {
  return color.value === "light" ? "solar:sun-2-bold" : "solar:moon-bold";
});

const items = [
  [
    {
      label: "Tharindu Nimesh",
      slot: "account",
      disabled: true,
    },
  ],
  [
    {
      label: "Settings",
      icon: "i-heroicons-cog-8-tooth",
      click: () => router.push("/app/settings"),
    },
    {
      label: "Console",
      icon: "heroicons:presentation-chart-line",
      click: () => router.push("/app/dashboard"),
    },
  ],
  [
    {
      label: "Vault",
      icon: "i-heroicons-inbox",
    },
    {
      label: "Cart",
      icon: "i-heroicons-shopping-cart",
      click: () => router.push("/cart"),
    },
    {
      label: "Favourite",
      icon: "i-heroicons-heart",
    },
  ],
  [
    {
      label: "Sign out",
      icon: "i-heroicons-arrow-left-on-rectangle",
      click: () => useAuthStore().logout(),
    },
  ],
];

function toggleTheme() {
  color.preference = color.preference === "dark" ? "light" : "dark";
}
</script>

<template>
  <header
    class="w-full flex justify-between h-16 bg-primary-light dark:bg-primary-dark rounded-lg"
  >
    <div class="h-full px-5 py-2 flex items-center">
      <UButton
        size="lg"
        icon="solar:hamburger-menu-outline"
        color="gray"
        class="rounded-full"
        @click="$emit('toggle-navbar')"
      />
    </div>

    <div class="flex px-5 gap-5 items-center">
      <div
        class="h-full flex items-center py-2 cursor-pointer"
        @click="toggleTheme"
      >
        <Icon
          :name="theme_icon"
          class="h-6 w-6 text-gray-400 dark:text-gray-500 animate-spin-slow duration-300"
        />
      </div>
      <UPopover
        :popper="{ arrow: true }"
        :ui="{ background: 'dark:bg-primary-dark' }"
      >
        <div class="h-full flex items-center py-2 cursor-pointer">
          <Icon
            name="solar:bell-bold"
            class="h-6 w-6 text-gray-400 dark:text-gray-500"
          />
        </div>

        <template #panel>
          <div class="p-4 w-[200px]">
            <div class="w-full flex justify-center">
              <span class="italic text-gray-500 dark:text-slate-400">
                No notifications
              </span>
            </div>
          </div>
        </template>
      </UPopover>
      <UDropdown
        :items="items"
        :ui="{
          item: { disabled: 'cursor-text select-text' },
        }"
        :popper="{ placement: 'bottom-start' }"
      >
        <UAvatar src="https://avatars.githubusercontent.com/u/739984?v=4" />

        <template #account="{ item }">
          <div class="text-left">
            <p>Signed in as</p>
            <p class="truncate font-medium text-gray-900 dark:text-white">
              {{ item.label }}
            </p>
          </div>
        </template>

        <template #item="{ item }">
          <span class="truncate">{{ item.label }}</span>

          <UIcon
            :name="item.icon"
            class="flex-shrink-0 h-4 w-4 text-gray-400 dark:text-gray-500 ms-auto"
          />
        </template>
      </UDropdown>
    </div>
  </header>
</template>

<style scoped>
.animate-spin-slow {
  transform: rotate(0deg);
}

.animate-spin-slow:hover {
  transform: rotate(360deg);
}
</style>
