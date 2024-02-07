<script setup>
const categories = [
  "esoteric",
  "manga",
  "science fiction",
  "fantasy",
  "comedy",
  "superhero",
  "action/adventure",
  "horror",
  "humour",
  "romance",
];
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
        <UDivider class="my-2" />
        <AppHeading title="Add new comic" />
        <div class="grid grid-cols-8 gap-3 mt-5">
          <div class="col-span-full md:col-span-5">
            <UFormGroup label="Name" required>
              <UInput placeholder="Name Of The Comic Book" />
            </UFormGroup>
          </div>
          <div class="col-span-full md:col-span-3">
            <UFormGroup label="Category" required>
              <USelectMenu
                searchable
                searchable-placeholder="Search a category..."
                placeholder="Select a category"
                :options="categories"
                model-value="superhero"
              />
            </UFormGroup>
          </div>
          <div class="col-span-full">
            <UFormGroup label="Description" required>
              <UTextarea variant="outline" placeholder="Add A Description" />
            </UFormGroup>
          </div>
          <div class="col-span-4">
            <UFormGroup label="Price" required>
              <UInputGroup>
                <UInput placeholder="Enter the Price" class="rounded-l-none" />
                <UInputGroupAddon class="rounded-r-none" label="ETH" />
              </UInputGroup>
            </UFormGroup>
          </div>
          <div class="col-span-4">
            <UFormGroup label="Issued Date" required>
              <UInputGroup>
                <UInput type="date" class="rounded-l-none" />
                <UInputGroupAddon class="rounded-r-none" label="ETH" />
              </UInputGroup>
            </UFormGroup>
          </div>
          <div class="col-span-full">
            <UFormGroup label="Images" hint="Max 5 Images" required>
              <div class="flex items-center justify-center w-full">
                <label
                  for="dropzone-file"
                  class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-[#2b2a33] hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-[#2b2a3388]"
                >
                  <div
                    class="flex flex-col items-center justify-center pt-5 pb-6"
                  >
                    <svg
                      class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                      aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 20 16"
                    >
                      <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                      />
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                      <span class="font-semibold">Click to upload</span> or drag
                      and drop
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                      SVG, PNG, JPG or GIF (MAX. 800x400px)
                    </p>
                  </div>
                  <input id="dropzone-file" type="file" class="hidden" />
                </label>
              </div>
            </UFormGroup>
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
