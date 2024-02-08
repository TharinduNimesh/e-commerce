<script setup>
const desciption = `"Batman: The Dark Knight Returns #1," a seminal comic written by
            Frank Miller and illustrated by Klaus Janson, is a gripping and
            influential entry in the Batman canon. Published in 1986 by DC
            Comics, this issue marks the beginning of a groundbreaking four-part
            miniseries that redefined the character and the superhero genre as a
            whole.
            <br />
            <br />
            Set in a dystopian future where Gotham City is overrun by crime and
            corruption, an aging Bruce Wayne comes out of retirement to don the
            cape and cowl once more. Miller's narrative explores a world
            grappling with moral decay, political turmoil, and a longing for the
            return of its caped crusader. Janson's dynamic artwork complements
            the gritty tone, capturing the intensity of Batman's resurgence and
            the harsh realities of the urban landscape.
            <br />
            <br />
            As Batman confronts a new breed of criminals and faces off against
            old adversaries, the story delves into themes of justice, aging, and
            the enduring spirit of a hero. "The Dark Knight Returns #1" is a
            pivotal chapter in Batman's history, contributing to the character's
            complex mythology and leaving an indelible mark on the comic book
            industry. This issue serves as a powerful introduction to a
            narrative that explores the psychological and physical toll of a
            lifetime dedicated to justice.`;

const offer_percentage = ref(66);
const product_price = ref(1000);
const images = ref([
  "/img/comics/batman-comic.png",
  "/img/comics/batman-1.webp",
  "/img/comics/batman-2.webp",
  "/img/comics/batman-3.jpg",
  "/img/comics/batman-4.webp",
  "/img/comics/batman-5.png",
]);
const active_image = ref(images.value[0]);

function calculatePrice() {
  let price = parseFloat(product_price.value);
  let offer = parseFloat(offer_percentage.value);
  return (price - (price * offer) / 100).toFixed(2);
}
</script>

<template>
  <div>
    <NuxtLayout name="app">
      <div
        class="w-full flex flex-col p-5 lg:p-8 bg-primary-light dark:bg-primary-dark rounded-lg"
      >
        <div class="w-full">
          <UButton
            color="black"
            variant="ghost"
            icon="i-heroicons-arrow-left-20-solid"
            @click="$router.back()"
            label="Go Back"
            size="lg"
          />
        </div>
        <UDivider class="my-5" />
        <div class="w-full flex gap-5 lg:gap-0 flex-wrap">
          <div
            class="relative w-full flex flex-col justify-center items-center lg:w-1/2"
          >
            <div
              :class="{
                'hidden lg:flex': active_image != images[0],
              }"
              class="absolute w-[80px] top-0 left-0"
            >
              <img src="/img/brands/dc.png" alt="DC Studios" class="w-full" />
            </div>
            <div class="w-4/5 max-w-[500px]">
              <img
                :src="active_image"
                alt="Batman Comic Cover"
                class="w-full max-h-[400px] object-contain"
              />
            </div>
            <div
              class="h-[80px] flex gap-1 mt-5 w-full overflow-x-scroll overflow-y-hidden"
            >
              <div
                v-for="image in images"
                :key="image"
                class="h-full flex-none cursor-pointer duration-300 hover:scale-105"
                @click="active_image = image"
              >
                <img
                  v-show="image != active_image"
                  :src="image"
                  alt="Batman Comic Cover"
                  class="h-full"
                />
              </div>
            </div>
          </div>
          <div class="w-full flex flex-col lg:w-1/2 px-5">
            <div class="flex flex-col w-full max-w-[700px]">
              <h1
                class="text-3xl font-bold uppercase text-gray-700 dark:text-slate-100"
              >
                Batman: The Dark Knight Returns #1
              </h1>
              <span
                class="text-lg font-semibold uppercase text-gray-400 dark:text-slate-400"
              >
                DC Comics
              </span>
            </div>
            <div class="flex justify-center py-5">
              <div class="grid grid-cols-3 w-full">
                <div class="col-span-1 flex flex-col items-center gap-1">
                  <Icon
                    name="material-symbols-light:kid-star-sharp"
                    class="text-2xl"
                  />
                  <span class="text-gray-700 dark:text-slate-100">8.5/10</span>
                </div>
                <div class="col-span-1 flex flex-col items-center gap-1">
                  <Icon
                    name="heroicons:shopping-cart-20-solid"
                    class="text-2xl"
                  />
                  <span class="text-gray-700 dark:text-slate-100">1, 100</span>
                </div>
                <div class="col-span-1 flex flex-col items-center gap-1">
                  <Icon name="i-heroicons-heart-solid" class="text-2xl" />
                  <span class="text-gray-700 dark:text-slate-100">3, 400</span>
                </div>
              </div>
            </div>
            <div class="text-gray-500 dark:text-gray-400" v-html="desciption" />
            <div class="w-full flex flex-col gap-3">
              <div class="w-full flex mt-5 py-2">
                <span v-if="offer_percentage">
                  <span
                    class="line-through text-red-500 dark:text-red-400 text-sm"
                    >LKR. {{ product_price }}</span
                  >
                  <span
                    class="text-green-500 dark:text-green-600 font-semibold text-xl"
                    >LKR. {{ calculatePrice() }}</span
                  >
                </span>
                <span
                  v-else
                  class="font-semibold text-xl text-gray-500 dark:text-gray-400"
                  >LKR. {{ product_price }}</span
                >
              </div>
              <div class="w-full grid grid-cols-12 gap-3">
                <div
                  class="col-span-full md:col-span-6 lg:col-span-7"
                >
                  <UButton
                    color="indigo"
                    block
                    size="lg"
                    class="uppercase"
                    label="View In Shop"
                    icon="solar:eye-outline"
                  />
                </div>
                <div
                  class="col-span-full md:col-span-6 lg:col-span-5"
                >
                  <UButton
                    color="orange"
                    block
                    size="lg"
                    class="uppercase"
                    label="Edit This"
                    icon="solar:pen-new-square-outline"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
