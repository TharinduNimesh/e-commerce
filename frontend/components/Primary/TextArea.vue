<script setup>
const props = defineProps(["label", "placeholder", "styles", "modelValue"]);
</script>

<template>
  <div class="w-full flex flex-col">
    <label class="uppercase text-sm mx-3">{{ label }}</label>
    <textarea
      rows="5"
      :placeholder="placeholder"
      class="w-full border border-gray-300 dark:border-gray-700 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-gray-300 dark:focus:ring-gray-700"
      :class="[
        styles,
        {
          'pr-10': type === 'password',
        },
      ]"
      :value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
    />
  </div>
</template>
