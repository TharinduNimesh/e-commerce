<script setup>
const slides = ref([
  {
    img: "1.png",
    title: "Game On, Haven Found Here.",
    content:
      "Discover a gaming paradise at GameHaven. Dive into exclusive titles, connect with fellow gamers, and elevate your play to new heights.",
  },
  {
    img: "2.png",
    title: "Pixels to Power, Game Haven.",
    content:
      "Unleash the gaming magic at GameHaven. Join us for exclusive releases, unbeatable deals, and a community where every gamer belongs.",
  },
  {
    img: "3.png",
    title: "Your Level, Your Rules, Haven.",
    content:
      "Game on your terms at GameHaven. Elevate your gaming experience with exclusive perks, community connections, and a world where every level matters.",
  },
]);
</script>

<template>
  <div class="w-full grid px-5">
    <div class="w-full md:w-2/3 place-self-center">
      <Carousel :autoplay="5000" :wrap-around="true">
        <Slide v-for="slide in slides" :key="slide.title">
          <div
            class="carousel__item h-full w-full rounded-xl shadow-lg dark:shadow-black"
          >
            <div
              class="carousel_img relative w-full h-full flex flex-col justify-center items-center bg-cover bg-center rounded-xl"
              :style="`--bg-img: url(/img/swiper/${slide.img})`"
            >
              <div
                class="absolute w-full h-full bg-gray-100 dark:bg-black opacity-40 dark:opacity-60 rounded-xl"
              ></div>
              <div
                class="relative w-2/3 flex flex-col justify-center items-center text-center"
              >
                <h2 class="text-4xl text-gray-800 dark:text-gray-200 font-bold">
                  {{ slide.title }}
                </h2>
                <p class="text-lg text-gray-700 dark:text-gray-400 mt-3">{{ slide.content }}</p>
              </div>
            </div>
          </div>
        </Slide>

        <template #addons>
          <Navigation />
          <Pagination />
        </template>
      </Carousel>
    </div>
  </div>
</template>

<style scoped>
.carousel_img {
  background-image: var(--bg-img);
}

.carousel__slide {
  width: 100%;
  height: 500px;
  overflow: hidden;
}
</style>
