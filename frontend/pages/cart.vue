<script setup>
const is_favorite = ref(false);

const offer_percentage = ref(66);
const product_price = ref(1000);

function calculatePrice(price, offer) {
  price = parseFloat(price);
  offer = parseFloat(offer);
  return (price - (price * offer) / 100).toFixed(2);
}
</script>

<template>
  <NuxtLayout name="home">
    <div class="flex justify-center pt-20">
      <div class="container flex flex-col pt-10 px-5 md:px-0">
        <div class="flex justify-between px-5">
          <div class="lg:col-span-1">
            <h1 class="main-heading">Your Cart</h1>
          </div>
          <div class="hidden lg:flex justify-end">
            <UButton to="/shop">Continue Shopping</UButton>
          </div>
        </div>
        <div class="w-full grid grid-cols-2 mt-5 gap-5">
          <div class="col-span-full lg:col-span-1 flex flex-col gap-3">
            <ShopCartItem
              v-for="item in 3"
              :key="item"
              id="1"
              name="Batman Gotham Knight #1"
              issuer="DC Comics"
              image="batman-comic.png"
              rating="8.5"
              favourite="2"
              product_price="1000"
              offer_percentage="66"
              buyers="10"
            />
          </div>
          <div class="col-span-full lg:col-span-1">
            <div
              class="w-full p-10 bg-primary-light dark:bg-primary-dark-transparent rounded shadow-lg dark:shadow-black"
            ></div>
          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
