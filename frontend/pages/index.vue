<script setup>
const is_loading = ref(false);
const comics = ref([]);
onMounted(() => {
  loadComics();
});
useHead({
  title: "Home | ComicCage",
});

async function loadComics() {
  is_loading.value = true;
  const { data } = await useApiFetch("/api/comics");
  if (data) {
    comics.value = data.comics;
    console.log(comics.value);
  }
  is_loading.value = false;
}
</script>

<template>
  <div>
    <NuxtLayout name="shop">
      <!-- Hero Section Start -->
      <section
        class="w-full flex flex-wrap min-h-screen pt-20 lg:pt-0 bg-cover bg-top bg-fixed bg-[url(/img/justice-league.png)]"
      >
        <div
          class="w-full lg:w-1/2 flex flex-col justify-center order-2 lg:order-1 px-5"
        >
          <div class="px-10 lg:px-8 py-5 lg:py-0 text-center lg:text-left">
            <h1 class="text-3xl lg:text-5xl font-extrabold">
              Unleash Adventures, Collect Memories,
              <span class="text-gradient from-blue-600 to-green-500">
                ComicCage
              </span>
              Awaits!
            </h1>
            <p
              class="md:text-lg lg:text-xl font-semibold text-gray-500 dark:text-gray-400 mt-5"
            >
              Explore a realm of digital wonders! Dive into riveting stories
              with ComicCage—your ultimate destination for downloadable comic
              book PDFs. Immerse yourself in captivating tales anytime,
              anywhere.
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
      </section>
      <!-- Hero section end -->

      <!-- Comic Releases Start -->
      <section class="w-full px-5 md:px-8 lg:px-10 pt-10">
        <h1 class="main-heading">Latest Releases</h1>
        <div class="w-full mt-8">
          <ShopScrollable unique="latest-scrollable">
            <div v-for="comic in comics" :key="comic._id">
              <ShopCard
                v-if="!comic.is_removed && !comic.is_hidden"
                :name="comic.name"
                :description="comic.description"
                :price="comic.price"
                :image="comic.images[0]"
                :id="comic._id"
              />
            </div>
          </ShopScrollable>
        </div>
        <h1 class="main-heading mt-10">Trending Offers</h1>
        <div class="w-full mt-8">
          <ShopScrollable unique="trending-scrollable">
            <ShopCard
              v-for="i in 10"
              :key="i"
              name="Hitman 3"
              description="Hitman 3 is a stealth game played from a third-person perspective and players once again assume control of assassin Agent 47."
              price="59.99"
              image="1.jpeg"
              offer="33"
            />
          </ShopScrollable>
        </div>
      </section>
      <!-- Comic Releases End -->

      <!-- Bento Grid Start -->
      <section class="w-full mt-10 px-5 lg:px-10 py-10">
        <div
          class="w-full grid grid-cols-12 grid-rows-3 gap-5 bg-cover bg-center bg-primary-light dark:bg-primary-dark bg-fixed bg-[url(/img/superman-carrying-the-world.png)]"
        >
          <div
            class="grid-col col-span-12 md:col-span-8 row-span-2 p-5 lg:p-10"
          >
            <div class="w-full flex justify-center">
              <h1
                class="text-5xl lg:text-6xl uppercase mb-5 font-bold text-gradient from-blue-400 via-green-500 to-violet-500"
              >
                Overview
              </h1>
            </div>
            <p
              class="text-lg font-semibold text-gray-600 dark:text-gray-400 font-mono capitalize"
            >
              your digital gateway to immersive storytelling! Dive into a vast
              collection of downloadable comic book PDFs, unlocking a universe
              of gripping narratives and stunning visuals. Join our community,
              where each click opens the door to thrilling adventures.
              Convenient, accessible, and curated for comic
              enthusiasts—ComicCage, where every page turns into an
              unforgettable journey.
            </p>
          </div>
          <div
            class="col-span-12 md:col-span-4 md:row-span-3 grid grid-cols-2 md:grid-rows-5 gap-5"
          >
            <div
              class="grid-col col-span-1 md:col-span-full md:row-span-2 flex flex-col justify-center items-center"
            >
              <h2
                class="text-5xl font-bold text-gradient from-blue-400 via-green-500 to-violet-500"
              >
                3,000+
              </h2>
              <span>
                <span
                  class="text-xl font-semibold text-gray-600 dark:text-gray-400"
                  >COMIC BOOKS</span
                >
              </span>
            </div>
            <div
              class="grid-col col-span-1 md:col-span-full md:row-span-3 flex flex-col justify-center items-center gap-4"
            >
              <span
                class="text-xl font-semibold text-gray-600 dark:text-gray-400"
              >
                UP TO
              </span>
              <h2
                class="text-5xl font-bold text-gradient from-blue-400 via-green-500 to-violet-500"
              >
                80%
              </h2>
              <span
                class="text-xl text-center font-semibold text-gray-600 dark:text-gray-400"
              >
                OFFERS ON COMICS
              </span>
            </div>
          </div>
          <div class="col-span-12 md:col-span-8 h-40 grid grid-cols-3 gap-5">
            <div
              class="grid-col flex flex-col justify-center items-center col-span-2"
            >
              <h2
                class="text-5xl font-bold text-gradient from-blue-400 via-green-500 to-violet-500"
              >
                500,000+
              </h2>
              <span>
                <span
                  class="text-xl font-semibold text-gray-600 dark:text-gray-400"
                  >COMIC READERS</span
                >
              </span>
            </div>
            <div
              class="grid-col col-span-1 flex flex-col justify-center items-center"
            >
              <h2
                class="text-5xl font-bold text-gradient from-blue-400 via-green-500 to-violet-500"
              >
                4.85
              </h2>
              <span>
                <span
                  class="text-xl font-semibold text-gray-600 dark:text-gray-400"
                  >RATING</span
                >
              </span>
            </div>
          </div>
        </div>
      </section>
      <!-- Bento Grid End -->

      <!-- Recomended Comics Start -->
      <section class="w-full min-h-screen py-10">
        <div class="w-full px-5 lg:px-10">
          <h1 class="main-heading">Recommended For You</h1>
          <div class="w-full mt-10 flex flex-wrap justify-center gap-5">
            <ShopCard
              v-for="i in 12"
              :key="i"
              name="Cyberpunk 2077"
              description="Cyberpunk 2077 is an open-world, action-adventure story set in Night City, a megalopolis obsessed with power, glamour and body modification."
              price="59.99"
              image="cyberpunk-2077.avif"
            />
          </div>
        </div>
      </section>
      <!-- Recomended Comics End -->
    </NuxtLayout>
  </div>
</template>

<style scoped>
.grid-col {
  @apply px-5 rounded-xl shadow-lg dark:shadow-black bg-blend-multiply bg-primary-light-transparent dark:bg-primary-dark-transparent border border-violet-300 dark:border-violet-900;
}
</style>
