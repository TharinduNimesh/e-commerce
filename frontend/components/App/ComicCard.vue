<!-- 
    This is the component that used in publisher page 
    to display most popular comics
-->

<script setup>
const props = defineProps({
  is_favorite: {
    type: Boolean,
    default: false,
  },
  offer_percentage: {
    type: String,
    default: 0,
  },
  product_price: {
    type: String,
    default: 0,
  },
  name: String,
  publisher: String,
  image: String,
  rating: String,
  buyers: String,
  favourite: String,
  id: Number,
});

function calculatePrice(price, offer) {
  price = parseFloat(price);
  offer = parseFloat(offer);
  return (price - (price * offer) / 100).toFixed(2);
}
</script>

<template>
  <div
    class="relative w-full flex flex-col p-5 bg-cover bg-right-bottom bg-[url(/img/game-card-bg.png)] bg-primary-light dark:bg-primary-dark-transparent rounded-lg shadow-lg dark:shadow-black"
  >
    <div class="grid grid-cols-12 col-span-full sm:h-[140px]">
      <div
        class="col-span-full sm:col-span-4 sm:h-[140px] flex justify-center items-center"
      >
        <img
          :src="`/img/comics/${image}`"
          class="rounded shadow-lg w-full max-w-[200px] sm:w-auto sm:h-full object-contain"
          alt="Comic"
        />
      </div>

      <div class="col-span-full sm:col-span-8 flex flex-col gap-3">
        <div class="flex flex-col w-full pr-10">
          <h1
            class="text-xl font-bold uppercase text-gray-700 dark:text-slate-100"
          >
            {{ name }}
          </h1>
        </div>
        <div class="flex justify-center">
          <div class="grid grid-cols-3 w-full">
            <div class="col-span-1 flex flex-col items-center gap-1">
              <Icon
                name="material-symbols-light:kid-star-sharp"
                class="text-xl"
              />
              <span class="text-gray-700 text-sm dark:text-slate-100"
                >{{ rating }}/10</span
              >
            </div>
            <div class="col-span-1 flex flex-col items-center gap-1">
              <Icon name="heroicons:shopping-cart-20-solid" class="text-xl" />
              <span class="text-gray-700 text-sm dark:text-slate-100">{{
                buyers
              }}</span>
            </div>
            <div class="col-span-1 flex flex-col items-center gap-1">
              <Icon name="i-heroicons-heart-solid" class="text-xl" />
              <span class="text-gray-700 text-sm dark:text-slate-100">{{
                favourite
              }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-span-full">
      <div class="w-full flex justify-center py-2">
        <span v-if="offer_percentage">
          <span class="line-through text-red-500 dark:text-red-400 text-xs"
            >LKR. {{ product_price }}</span
          >
          <span class="text-green-500 dark:text-green-600 font-semibold"
            >LKR. {{ calculatePrice(product_price, offer_percentage) }}</span
          >
        </span>
        <span
          v-else
          class="font-semibold text-xl text-gray-500 dark:text-gray-400"
          >LKR. {{ product_price }}</span
        >
      </div>
      <div class="flex gap-3">
        <UButton color="gray" icon="material-symbols:shopping-cart-rounded" />
        <div class="flex-1">
          <UButton
            to="/app/comics/1"
            color="black"
            label="View Comic"
            icon="solar:eye-outline"
            block
          />
        </div>
      </div>
    </div>
  </div>
</template>
