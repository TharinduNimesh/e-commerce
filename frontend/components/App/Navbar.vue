<script setup>
defineProps({
  is_open: Boolean,
});
</script>

<template>
  <div
    class="absolute lg:static h-full bg-primary-light dark:bg-primary-dark rounded-r-lg transition-[width] duration-300"
    :class="{
      'w-0': !is_open,
      'w-[280px]': is_open,
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
  </div>
</template>
