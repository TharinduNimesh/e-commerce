<script setup lang="js">
const comics = ref([]);

onMounted(async () => {
  const { data } = await useApiFetch("/api/comics/bought");
  if (data) {
    comics.value = data.comics;
  }
  console.log(comics.value);
});
</script>

<template>
  <div>
    <NuxtLayout name="shop">
      <div class="flex justify-center py-20">
        <div class="container flex flex-col pt-10 px-5 md:px-0">
          <div class="lg:col-span-1">
            <h1 class="main-heading">Purchased History</h1>
          </div>
          <div class="grid grid-cols-2">
            <div class="col-span-full lg:col-span-1 flex flex-col gap-5 p-4">
              <div class="flex flex-col gap-3">
                <ShopVaultItem
                  v-for="comic in comics"
                  :key="comic._id"
                  :name="comic.name"
                  :image="comic.images[0]"
                  rating="8.5"
                  favourite="2"
                  buyers="10"
                />
              </div>
            </div>
            <div
              class="col-span-full lg:col-span-1 p-5 lg:p-10 flex justify-center items-center"
            >
              <img
                src="/img/captain_america_with_hammer.jpg"
                class="h-[400px] bg-cover bg-center"
                alt="Captain America"
              />
            </div>
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
