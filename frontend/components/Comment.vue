<script setup>
defineProps(["name", "comment", "date"]);
const items = [
  [
    {
      label: "Report",
      icon: "ph:flag",
    },
  ],
];
</script>

<template>
  <div
    class="w-full flex border gap-3 bg-primary-light dark:bg-primary-dark-transparent border-gray-300 dark:border-gray-600 rounded px-5 py-3"
  >
    <div class="h-full flex justify-center">
      <UAvatar src="https://picsum.photos/200" alt="Avatar" />
    </div>
    <div class="h-full flex-1 flex flex-col">
      <div class="flex justify-between items-center">
        <span class="text-gray-700 dark:text-slate-100 font-semibold">
          {{ name }}
        </span>
        <div class="flex gap-3">
          <span class="text-gray-500 dark:text-gray-400 text-sm">
            {{ date }}
          </span>
          <UDropdown :items="items" :popper="{ placement: 'bottom-start' }">
            <Icon
              name="bi:three-dots"
              class="text-gray-700 dark:text-gray-300 text-xl cursor-pointer"
            />
          </UDropdown>
        </div>
      </div>
      <div class="text-gray-500 dark:text-gray-400 text-sm pr-10">
        {{ comment }}
      </div>
    </div>
  </div>
</template>
