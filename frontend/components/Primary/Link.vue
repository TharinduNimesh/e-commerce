<script setup>
defineProps(["text", "to"]);
</script>

<template>
  <NuxtLink :to="to" @click="$emit('onclick', $event)" class="text-sm text-blue-600 cursor-pointer">
    {{ text }}
  </NuxtLink>
</template>
