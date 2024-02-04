<script setup>
defineProps({
  path: String,
  icon: String,
  name: String,
  is_active: Boolean,
});
</script>

<template>
  <NuxtLink
    :to="path"
    class="w-full flex items-center rounded-lg gap-3 p-3"
    :class="{
      'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-secondary-dark/30 cursor-pointer':
        !is_active,
      'bg-violet-500 dark:bg-violet-600 text-slate-200': is_active,
    }"
  >
    <Icon :name="icon" class="text-lg" />
    <span class="font-semibold">{{ name }}</span>
  </NuxtLink>
</template>
