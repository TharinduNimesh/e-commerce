<script setup>
const route = useRoute();
const is_loading = ref(false);
const data = ref(null);
const id = route.params.id;
const images = ref([
  "/img/comics/batman-comic.png",
  "/img/comics/batman-1.webp",
  "/img/comics/batman-2.webp",
  "/img/comics/batman-3.jpg",
  "/img/comics/batman-4.webp",
  "/img/comics/batman-5.png",
]);
const active_image = ref(null);
onMounted(async () => {
  await loadData();
  if (data.value != "not_found") {
    active_image.value = data.value.images[0];
  }
});

function calculatePrice() {
  if (data?.value && data?.value?.has_discount) {
    let price = parseFloat(data.value.price);
    let offer = parseFloat(data.value.discount);
    return (price - (price * offer) / 100).toFixed(2);
  }
}

async function loadData() {
  is_loading.value = true;
  const { data: comic } = await useApiFetch(`/api/comics/${id}`, {}, false);
  if (comic) {
    data.value = comic.comic;
  } else {
    data.value = "not_found";
    useNotifications().value.push({
      type: "warning",
      message: "Failed to load comic data",
    });
  }
  is_loading.value = false;
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
        <AppProductSkeleton v-if="is_loading" />
        <template v-else>
          <div v-if="data == 'not_found'" class="w-full flex flex-col">
            <div class="w-full flex flex-col items-center">
              <h1
                class="text-4xl uppercase text-gradient from-green-600 dark:from-green-700 to-violet-500 dark:to-violet-500 font-extrabold"
              >
                Comic Not Fount
              </h1>
              <span class="text-lg font-bold text-center">
                We couldn't find the comic you are looking for, please try
                refreshing the page or
                <ULink
                  @click="$router.back()"
                  active-class="text-primary"
                  inactive-class="text-primary"
                >
                  Go Back </ULink
                >.
              </span>
            </div>
          </div>
          <div
            class="w-full flex gap-5 lg:gap-0 flex-wrap"
            v-else-if="data != null"
          >
            <div
              class="relative w-full flex flex-col justify-center items-center lg:w-1/2"
            >
              <div
                :class="{
                  'hidden lg:flex': active_image != images[0],
                }"
                class="absolute w-[80px] top-0 left-0"
              >
                <img :src="`${$config.public.apiURL}/storage${data.publisher.logo}`" alt="DC Studios" class="w-full" />
              </div>
              <div class="w-4/5 max-w-[500px]">
                <img
                  :src="`${$config.public.apiURL}/storage${active_image}`"
                  alt="Batman Comic Cover"
                  class="w-full max-h-[400px] object-contain"
                />
              </div>
              <div
                class="h-[80px] flex gap-1 mt-5 w-full overflow-x-scroll overflow-y-hidden"
              >
                <div
                  v-for="image in data.images"
                  :key="image"
                  class="h-full flex-none cursor-pointer duration-300 hover:scale-105"
                  @click="active_image = image"
                >
                  <img
                    v-show="image != active_image"
                    :src="`${$config.public.apiURL}/storage${image}`"
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
                  {{ data.name }}
                </h1>
                <span
                  class="text-lg font-semibold uppercase text-gray-400 dark:text-slate-400"
                >
                  {{ data.publisher.name }}
                </span>
              </div>
              <div class="flex justify-center py-5">
                <div class="grid grid-cols-3 w-full">
                  <div class="col-span-1 flex flex-col items-center gap-1">
                    <Icon
                      name="material-symbols-light:kid-star-sharp"
                      class="text-2xl"
                    />
                    <span class="text-gray-700 dark:text-slate-100"
                      >8.5/10</span
                    >
                  </div>
                  <div class="col-span-1 flex flex-col items-center gap-1">
                    <Icon
                      name="heroicons:shopping-cart-20-solid"
                      class="text-2xl"
                    />
                    <span class="text-gray-700 dark:text-slate-100"
                      >1, 100</span
                    >
                  </div>
                  <div class="col-span-1 flex flex-col items-center gap-1">
                    <Icon name="i-heroicons-heart-solid" class="text-2xl" />
                    <span class="text-gray-700 dark:text-slate-100"
                      >3, 400</span
                    >
                  </div>
                </div>
              </div>
              <div
                class="text-gray-500 dark:text-gray-400"
                v-html="data.description"
              />
              <div class="w-full flex flex-col gap-3">
                <div class="w-full flex mt-5 py-2">
                  <span v-if="data.has_discount">
                    <span
                      class="line-through text-red-500 dark:text-red-400 text-sm"
                      >LKR. {{ data.price }}</span
                    >
                    <span
                      class="text-green-500 dark:text-green-600 font-semibold text-xl"
                      >LKR. {{ calculatePrice() }}</span
                    >
                  </span>
                  <span
                    v-else
                    class="font-semibold text-xl text-gray-500 dark:text-gray-400"
                    >LKR. {{ data.price }}</span
                  >
                </div>
                <div class="w-full grid grid-cols-12 gap-3">
                  <div class="col-span-full md:col-span-6 lg:col-span-7">
                    <UButton
                      color="indigo"
                      block
                      size="lg"
                      class="uppercase"
                      label="View In Shop"
                      icon="solar:eye-outline"
                      :to="`/comic/${id}`"
                    />
                  </div>
                  <div class="col-span-full md:col-span-6 lg:col-span-5">
                    <UButton
                      color="orange"
                      block
                      size="lg"
                      class="uppercase"
                      label="Edit This"
                      icon="solar:pen-new-square-outline"
                      :to="`/app/comics/edit/${id}`"
                    />
                  </div>
                  <div
                    class="col-span-full italic flex flex-col text-gray-400 dark:text-gray-500 items-end mt-5 gap-2"
                  >
                    <!-- <span>
                      Issued At :
                      {{ getFormatedDate(new Date(data.issued_at)) }}
                    </span>
                    <span>
                      Published At (ComicCage) :
                      {{ getFormatedDate(new Date(data.created_at)) }}
                    </span>
                    <span>
                      Last Update :
                      {{ getFormatedDate(new Date(data.updated_at)) }}
                    </span> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </div>
    </NuxtLayout>
  </div>
</template>
