<script setup>
defineProps({
  title: String,
});
</script>

<template>
  <h1 class="text-2xl font-bold uppercase text-gray-700 dark:text-slate-200">
    {{ title }}
  </h1>
</template>
