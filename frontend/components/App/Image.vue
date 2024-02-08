<script setup>
defineProps({
  name: String,
  image: String,
  primary: {
    type: Boolean,
    default: false,
  },
});

const items = [
  [
    {
      label: "Mark As Cover Image",
      icon: "solar:pen-2-outline",
    },
    {
      label: "Delete",
      icon: "solar:trash-bin-2-outline",
    },
  ],
];
</script>

<template>
  <div
    class="relative h-20"
    :class="{
      'p-1 bg-violet-500 dark:bg-violet-700 rounded-lg': primary,
    }"
  >
    <!-- Right Corner Action Start -->
    <div
      v-if="primary"
      class="absolute p-[2px] h-5 -right-2 -top-2 flex justify-center items-center bg-violet-500 dark:bg-violet-700 rounded-full cursor-pointer"
    >
      <Icon name="solar:close-circle-linear" class="text-slate-100" />
    </div>
    <UDropdown
      v-else
      :items="items"
      class="absolute p-[2px] h-5 -right-2 -top-2 flex justify-center items-center bg-violet-500 dark:bg-violet-700 rounded-full cursor-pointer"
      :popper="{
        arrow: true,
      }"
    >
      <Icon name="solar:menu-dots-bold" class="text-slate-100" />
    </UDropdown>
    <!-- Right Corner Action Start -->

    <img :src="image" :alt="name" class="rounded-lg h-full" />
  </div>
</template>
