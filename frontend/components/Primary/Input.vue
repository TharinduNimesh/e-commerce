<script setup>
const props = defineProps(["label", "placeholder", "type", "modelValue"]);

const displayType = ref(props.type);

function toggleType() {
  if (displayType.value === "password") {
    displayType.value = "text";
  } else {
    displayType.value = "password";
  }
}
</script>

<template>
  <div class="w-full flex flex-col">
    <label class="uppercase text-sm mx-3">{{ label }}</label>
    <div class="flex relative">
      <input
        :type="displayType"
        :placeholder="placeholder"
        class="w-full h-11 border border-gray-300 dark:border-gray-700 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-1 focus:ring-gray-300 dark:focus:ring-gray-700"
        :class="{
          'pr-10': type === 'password',
        }"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
      />
      <div
        class="absolute h-11 w-10 flex justify-center items-center right-0 bottom-0 cursor-pointer"
        v-if="type === 'password'"
        @click="toggleType"
      >
        <Icon
          name="material-symbols:visibility-outline"
          v-show="displayType === 'password'"
        />
        <Icon
          name="material-symbols:visibility-off-outline"
          v-show="displayType === 'text'"
        />
      </div>
    </div>
  </div>
</template>
