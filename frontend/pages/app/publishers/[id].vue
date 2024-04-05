<script setup>
const route = useRoute();
const is_loading = ref(false);
const publisher = ref({});
const id = route.params.id;
onMounted(() => {
  loadPublisher();
});

async function loadPublisher() {
  is_loading.value = true;
  const { data } = await useApiFetch(`/api/publishers/${id}`);
  if (data) {
    publisher.value = data.publisher;
  }
  is_loading.value = false;
}
</script>

<template>
  <div>
    <NuxtLayout name="app">
      <div
        class="w-full p-5 flex flex-col lg:p-8 bg-primary-light dark:bg-primary-dark rounded-lg"
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
        <UDivider class="my-3" />
        <div v-if="is_loading" class="w-full grid grid-cols-2 gap-3">
          <div class="col-span-full">
            <USkeleton class="w-full h-[160px] rounded-lg" />
          </div>
          <div class="col-span-full">
            <USkeleton class="w-full max-w-[300px] h-[30px] rounded-lg" />
          </div>
          <USkeleton class="w-full h-[130px] rounded-lg" />
          <USkeleton class="w-full h-[130px] rounded-lg" />
          <USkeleton class="w-full h-[130px] rounded-lg" />
          <USkeleton class="w-full h-[130px] rounded-lg" />
        </div>
        <div v-else-if="publisher == null" class="w-full">
          <!-- design for not found -->
          <div class="w-full flex flex-col items-center gap-5">
            <div class="w-full flex flex-col items-center">
              <h1
                class="text-4xl uppercase text-gradient from-green-600 dark:from-green-700 to-violet-500 dark:to-violet-500 font-extrabold"
              >
                Publisher Not Fount
              </h1>
              <span class="text-lg font-bold text-center">
                The publisher you are looking for is not found. Please try
                refreshing the page or go back by clicking
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
        </div>
        <div v-else class="w-full flex flex-col">
          <div class="w-full flex flex-col md:flex-row items-center gap-5">
            <div
              class="relative h-[100px] p-2 flex justify-center items-center rounded shadow-md dark:shadow-black"
            >
              <img
                :src="`${$config.public.apiURL}/storage${publisher.logo}`"
                alt="DC Comics"
                class="h-full"
              />
            </div>
            <h1 class="text-2xl font-bold md:hidden">{{ publisher.name }}</h1>
            <div class="flex flex-col gap-5 flex-1 w-full">
              <h1 class="text-2xl font-bold hidden md:block">
                {{ publisher.name }}
              </h1>
              <div class="flex justify-between w-full md:w-3/4">
                <div class="flex flex-col gap-1">
                  <div
                    class="flex items-center gap-3 text-gray-700 dark:text-gray-200"
                  >
                    <Icon class="text-xl" name="solar:crown-bold" />
                    <span class="text-sm font-bold uppercase hidden sm:block"
                      >Rank</span
                    >
                  </div>
                  <span class="font-semibold text-gray-500 dark:text-slate-400">
                    1
                  </span>
                </div>

                <div class="flex flex-col gap-1">
                  <div
                    class="flex items-center gap-3 text-gray-700 dark:text-gray-200"
                  >
                    <Icon
                      class="text-xl"
                      name="solar:book-bookmark-minimalistic-bold"
                    />
                    <span class="text-sm font-bold uppercase hidden sm:block">
                      Total publishes
                    </span>
                  </div>
                  <span class="font-semibold text-gray-500 dark:text-slate-400">
                    100
                  </span>
                </div>

                <div class="flex flex-col gap-1">
                  <div
                    class="flex items-center gap-3 text-gray-700 dark:text-gray-200"
                  >
                    <Icon class="text-xl" name="solar:user-bold" />
                    <span class="text-sm font-bold uppercase hidden sm:block">
                      Total Buyers
                    </span>
                  </div>
                  <span class="font-semibold text-gray-500 dark:text-slate-400">
                    1, 000
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <UDivider class="my-3" />

        <AppHeading title="Most Popular Comics" class="mb-3" />
        <div v-if="publisher != null && publisher.comics" class="w-full">
          <div v-if="publisher.comics.length == 0">
            <div class="w-full flex flex-col items-center gap-5">
              <div class="w-full flex flex-col items-center">
                <h1
                  class="text-4xl uppercase text-gradient from-green-600 dark:from-green-700 to-violet-500 dark:to-violet-500 font-extrabold"
                >
                  Comics Not Fount
                </h1>
                <span class="text-lg font-bold text-center">
                  The comics you are looking for is not found. Please try
                  refreshing the page or go back by clicking
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
          </div>
          <div v-else class="w-full grid lg:grid-cols-2 gap-5">
            <AppComicCard
              v-for="comic in publisher.comics"
              :key="comic._id"
              :id="comic._id"
              :name="comic.name"
              :image="comic.images[0]"
              :price="comic.price"
              :discount="comic.discount"
              rating="8.5"
              favourite="2"
              buyers="10"
            />
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
