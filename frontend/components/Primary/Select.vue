<script setup>
defineProps(["label", "placeholder", "options", "modelValue"]);
</script>

<template>
  <div class="flex flex-col">
    <label class="uppercase text-sm mx-3">{{ label }}</label>
    <select
      class="w-full mt-1 h-11 bg-slate-50 dark:bg-[#2b2a33] rounded border border-gray-300 dark:border-gray-700 outline-none px-3"
      @change="$emit('update:modelValue', $event.target.value)"
    >
      <option :value="null">{{ placeholder }}</option>
      <option
        v-for="option in options"
        :key="option.value"
        :value="option.value"
        :selected="option.value === modelValue"
      >
        {{ option.label }}
      </option>
    </select>
  </div>
</template>
