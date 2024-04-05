<script setup>
const props = defineProps([
  "name",
  "description",
  "price",
  "image",
  "offer",
  "id",
]);

function truncateWords(inputString, maxWords) {
  let words = inputString.split(/\s+/);
  if (words.length <= maxWords) {
    return inputString;
  }
  return words.slice(0, maxWords).join(" ");
}

function calculatePrice() {
  let price = parseFloat(props.price);
  let offer = parseFloat(props.offer);
  return (price - (price * offer) / 100).toFixed(2);
}
</script>

<template>
  <div
    class="relative flex overflow-hidden flex-col flex-none w-[300px] h-full bg-primary-light dark:bg-primary-dark bg-cover bg-right-bottom bg-[url(/img/game-card-bg.png)] border border-indigo-200 dark:border-indigo-900 shadow-lg hover:-translate-y-2 transition-transform duration-300 dark:shadow-black rounded-lg"
  >
    <div
      class="absolute top-4 -left-10 w-[150px] bg-red-500 -rotate-45 flex justify-center items-center text-center"
      v-if="offer"
    >
      <span class="text-white text-sm font-bold uppercase">{{ offer }}%</span>
    </div>
    <div class="w-full h-[240px] rounded-t-lg">
      <img
        :src="`${$config.public.apiURL}/storage${image}`"
        :alt="name"
        class="w-full h-full object-cover rounded-t-lg"
      />
    </div>
    <div class="w-full flex flex-col px-5 py-3 justify-between h-full">
      <div>
        <h3 class="text-xl font-bold uppercase text-center">{{ name }}</h3>
        <p
          class="text-gray-600 dark:text-gray-400"
          v-html="`${truncateWords(description, 15)}...`"
        ></p>
      </div>
      <div class="grid grid-cols-4 gap-2 mt-3">
        <div class="col-span-full flex justify-center py-2">
          <span v-if="offer">
            <span class="line-through text-red-500 dark:text-red-400 text-xs"
              >USD. {{ price }}</span
            >
            <span class="text-green-500 dark:text-green-600 font-semibold"
              >USD. {{ calculatePrice() }}</span
            >
          </span>
          <span v-else>USD. {{ price }}</span>
        </div>
        <div class="col-span-1">
          <UButton
            color="red"
            block
            size="md"
            class="h-full"
            icon="i-heroicons-heart-20-solid"
          />
        </div>
        <div class="col-span-3">
          <UButton
            color="indigo"
            block
            class="h-full"
            label="Buy Now"
            icon="i-heroicons-shopping-cart-20-solid"
            :to="`/comic/${id}`"
          />
        </div>
      </div>
    </div>
  </div>
</template>
