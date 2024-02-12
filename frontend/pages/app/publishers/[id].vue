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
        <div class="w-full flex flex-col">
          <div class="w-full flex flex-col md:flex-row items-center gap-5">
            <div
              class="relative w-[150px] h-[150px] p-2 flex justify-center items-center rounded shadow-md dark:shadow-black"
            >
              <img src="/img/brands/dc.png" alt="DC Comics" class="w-full" />
              <UButton
                size="sm"
                color="black"
                variant="ghost"
                icon="solar:pen-new-square-outline"
                class="absolute top-0 right-0"
              />
            </div>
            <h1 class="text-2xl font-bold md:hidden">DC Comics</h1>
            <div class="flex flex-col gap-5 flex-1 w-full">
              <h1 class="text-2xl font-bold hidden md:block">DC Comics</h1>
              <div class="flex justify-between w-full md:w-3/4">
                <div class="flex flex-col gap-1">
                  <div class="flex items-center gap-3 text-gray-700 dark:text-gray-200">
                    <Icon class="text-xl" name="solar:crown-bold" />
                    <span class="text-sm font-bold uppercase">Rank</span>
                  </div>
                  <span class="font-semibold text-gray-500 dark:text-slate-400">
                    1
                  </span>
                </div>

                <div class="flex flex-col gap-1">
                  <div class="flex items-center gap-3 text-gray-700 dark:text-gray-200">
                    <Icon
                      class="text-xl"
                      name="solar:book-bookmark-minimalistic-bold"
                    />
                    <span class="text-sm font-bold uppercase">
                      Total publishes
                    </span>
                  </div>
                  <span class="font-semibold text-gray-500 dark:text-slate-400">
                    100
                  </span>
                </div>

                <div class="flex flex-col gap-1">
                  <div class="flex items-center gap-3 text-gray-700 dark:text-gray-200">
                    <Icon class="text-xl" name="solar:user-bold" />
                    <span class="text-sm font-bold uppercase">
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
      </div>
    </NuxtLayout>
  </div>
</template>
