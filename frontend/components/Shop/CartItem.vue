<script setup>
const emit = defineEmits(["onremove"]);
const props = defineProps({
  is_favorite: {
    type: Boolean,
    default: false,
  },
  discount: {
    type: String,
    default: 0,
  },
  product_price: {
    type: String,
    default: 0,
  },
  has_discount: {
    type: Boolean,
    default: false,
  },
  name: String,
  publisher: String,
  image: String,
  rating: String,
  buyers: String,
  favourite: String,
  id: String,
});

function calculatePrice(price, offer) {
  price = parseFloat(price);
  offer = parseFloat(offer);
  return (price - (price * offer) / 100).toFixed(2);
}

function remove() {
  emit("onremove", props.id);
}
</script>

<template>
  <div
    class="relative w-full grid grid-cols-12 p-5 bg-cover bg-right-bottom bg-[url(/img/game-card-bg.png)] bg-primary-light dark:bg-primary-dark-transparent rounded-lg shadow-lg dark:shadow-black"
    :key="id"
  >
    <div class="absolute top-2 right-5 p-2" @click="is_favorite = !is_favorite">
      <Icon
        v-if="is_favorite"
        name="i-heroicons-heart-20-solid"
        class="text-2xl text-red-500 dark:text-red-400"
      />
      <Icon
        v-else
        name="i-heroicons-heart"
        class="text-2xl text-red-500 dark:text-red-400"
      />
    </div>
    <div class="col-span-full flex justify-center sm:col-span-4 pr-3">
      <img
        :src="`${$config.public.apiURL}/storage${image}`"
        class="rounded shadow-lg max-h-[200px]"
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
        <span
          class="text-sm font-semibold uppercase text-gray-400 dark:text-slate-400"
        >
          {{ publisher }}
        </span>
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
      <div class="w-full flex justify-center py-2">
        <span v-if="has_discount">
          <span class="line-through text-red-500 dark:text-red-400 text-xs"
            >LKR. {{ product_price }}</span
          >
          <span class="text-green-500 dark:text-green-600 font-semibold"
            >LKR. {{ calculatePrice(product_price, discount) }}</span
          >
        </span>
        <span
          v-else
          class="font-semibold text-xl text-gray-500 dark:text-gray-400"
          >LKR. {{ product_price }}</span
        >
      </div>
      <div class="flex gap-3">
        <UButton
          color="red"
          icon="material-symbols:delete-sharp"
          @click="remove"
        />
        <div class="flex-1">
          <UButton
            label="Visit Product"
            icon="material-symbols:shopping-cart-rounded"
            block
            :to="`/comic/${id}`"
          />
        </div>
      </div>
    </div>
  </div>
</template>
