<script setup>
defineProps({
  text: {
    type: String,
    required: true,
  },
  style: {
    type: String,
    default: "bg-blue-500 hover:bg-blue-700 dark:bg-blue-800 dark:hover:bg-blue-900",
  },
  isDisabled: {
    type: Boolean,
    default: false,
  },
  isLoading: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <button
    class="w-full flex items-center justify-center py-2 rounded text-gray-100 dark:text-gray-300 font-bold uppercase shadow-md dark:shadow-black duration-300"
    :class="[
      style,
      {
        'opacity-80 cursor-not-allowed': isDisabled || isLoading,
      },
    ]"
    @click="$emit('onclick', $event)"
    :disabled="isDisabled || isLoading"
  >
    <Icon
      name="mingcute:loading-3-fill"
      class="text-lg mr-5 animate-spin"
      v-show="isLoading"
    />
    {{ text }}
  </button>
</template>
