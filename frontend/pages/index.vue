<script setup>
useHead({
  title: "Home | GameHeaven",
});
</script>

<template>
  <div
    class="w-full bg-gray-100 dark:bg-secondary-dark bg-repeat-y bg-contain bg-[url(/img/shop-bg.png)]"
  >
    <ShopHeader />
    <div class="w-full">
      <div
        class="w-full flex flex-wrap min-h-screen pt-20 lg:pt-0 bg-cover bg-top bg-fixed bg-[url(/img/justice-league.png)]"
      >
        <div
          class="w-full lg:w-1/2 flex flex-col justify-center order-2 lg:order-1 px-5"
        >
          <div class="px-16 lg:px-8 py-5 lg:py-0 text-center lg:text-left">
            <h1
              class="text-3xl lg:text-5xl xl:text-6xl font-extrabold text-gradient from-blue-600 via-green-500 to-indigo-400"
            >
              Game On, Haven Found Here.
            </h1>
            <p
              class="md:text-lg lg:text-xl font-semibold text-gray-500 dark:text-gray-400 mt-5"
            >
              Discover a gaming paradise at GameHaven. Dive into exclusive
              titles, connect with fellow gamers, and elevate your play to new
              heights.
            </p>
          </div>
        </div>
        <div
          class="w-full lg:w-1/2 py-5 flex justify-center items-center order-1 lg:order-2"
        >
          <img
            src="/img/hero.png"
            alt="A Boy with VR Box"
            class="w-2/3 max-w-[400px] animate-float"
          />
        </div>
      </div>
      <div class="w-full h-screen"></div>
      <div class="w-full h-screen"></div>
      <div class="w-full h-screen"></div>
    </div>
  </div>
</template>
