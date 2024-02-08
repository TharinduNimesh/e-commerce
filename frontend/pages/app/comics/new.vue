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
          <div class="col-span-full md:col-span-4">
            <UFormGroup label="Price" required>
              <UInputGroup>
                <UInput placeholder="Enter the Price" class="rounded-l-none" />
                <UInputGroupAddon class="rounded-r-none" label="ETH" />
              </UInputGroup>
            </UFormGroup>
          </div>
          <div class="col-span-full md:col-span-4">
            <UFormGroup label="Issued Date" required>
              <UInputGroup>
                <UInput type="date" class="rounded-l-none" />
                <UInputGroupAddon class="rounded-r-none" label="ETH" />
              </UInputGroup>
            </UFormGroup>
          </div>
          <div class="col-span-full">
            <div class="flex flex-col gap-5">
              <UFormGroup label="Images" hint="Max 5 Images" required>
                <FileUploader />
              </UFormGroup>
              <div class="flex gap-3 flex-wrap">
                <AppImage image="https://via.placeholder.com/400x200" primary />
                <AppImage image="https://via.placeholder.com/150x200" />
                <AppImage image="https://via.placeholder.com/1280x720" />
                <AppImage image="https://via.placeholder.com/150" />
                <AppImage image="https://via.placeholder.com/400x200" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
