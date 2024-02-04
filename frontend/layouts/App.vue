<script setup>
const is_navbar_open = useNavbarState();
const current_year = new Date().getFullYear();

function toggleNavbar() {
  is_navbar_open.value = !is_navbar_open.value;
}
</script>

<template>
  <div class="flex w-full h-screen bg-slate-200 dark:bg-secondary-dark">
    <AppNavbar :is_open="is_navbar_open" @toggle-navbar="toggleNavbar" />
    <div class="flex-1 p-3 flex flex-col justify-between">
      <div class="flex flex-col gap-4">
        <AppHeader @toggle-navbar="toggleNavbar" />
        <div class="w-full">
          <slot />
        </div>
      </div>
      <div
        class="w-full px-5 py-3 md:py-5 text-center md:text-left flex flex-col md:flex-row items-center justify-between bg-primary-light dark:bg-primary-dark rounded-lg"
      >
        <span class="text-gray-600 dark:text-slate-300">
          Design And Developed By <strong>Tharindu Nimesh</strong>.
        </span>
        <span class="text-gray-600 dark:text-slate-300">
          &copy; Copyright {{ current_year }}
          <strong>ComicCage</strong> Alright Reserved.
        </span>
      </div>
    </div>
  </div>
</template>
