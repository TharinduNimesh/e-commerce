<script setup>
const is_add_category_open = ref(false);
const columns = [
  {
    label: "Name",
    key: "name",
    sortable: true,
  },
  {
    label: "Comics",
    key: "comics",
    sortable: true,
  },
  {
    label: "Buyers",
    key: "buyers",
    sortable: true,
  },
  {
    label: "Action",
    key: "action",
    sortable: false,
  },
];

const categories = ref([
  {
    id: 1,
    name: "Action/Adventures",
    comics: 20,
    buyers: 50,
  },
  {
    id: 1,
    name: "Drama",
    comics: 30,
    buyers: 100,
  },
  {
    id: 1,
    name: "Esoteric",
    comics: 10,
    buyers: 10,
  },
  {
    id: 1,
    name: "Manga",
    comics: 15,
    buyers: 20,
  },
  {
    id: 1,
    name: "Science Fiction",
    comics: 5,
    buyers: 5,
  },
  {
    id: 1,
    name: "Fantasy",
    comics: 25,
    buyers: 30,
  },
  {
    id: 1,
    name: "Comedy",
    comics: 35,
    buyers: 40,
  },
  {
    id: 1,
    name: "Horror",
    comics: 40,
    buyers: 60,
  },
  {
    id: 1,
    name: "Humour",
    comics: 45,
    buyers: 70,
  },
  {
    id: 1,
    name: "Romance",
    comics: 50,
    buyers: 80,
  },
]);

const page = ref(1);
const pageCount = 5;

const rows = computed(() => {
  return categories.value.slice(
    (page.value - 1) * pageCount,
    page.value * pageCount
  );
});
</script>

<template>
  <div>
    <NuxtLayout name="app">
      <div
        class="w-full p-5 lg:p-8 bg-primary-light dark:bg-primary-dark rounded-lg"
      >
        <div class="flex items-center justify-between">
          <AppHeading title="Comic Categories" />
          <UButton
            color="black"
            label="Add New Category"
            icon="solar:add-circle-bold"
            @click="is_add_category_open = true"
          />
        </div>
        <div class="w-full mt-3">
          <div class="border border-slate-500/40 rounded-lg mt-5 px-2">
            <UTable :columns="columns" :rows="rows">
              <!-- custom columns start -->

              <template #comics-data="{ row }">
                {{ row.comics }} comics
              </template>

              <template #buyers-data="{ row }">
                <UBadge v-if="row.buyers < 20" color="red" variant="subtle">
                  {{ row.buyers }} Buyers
                </UBadge>
                <UBadge
                  v-else-if="row.buyers < 50"
                  color="yellow"
                  variant="subtle"
                >
                  {{ row.buyers }} Buyers
                </UBadge>
                <UBadge v-else color="green" variant="subtle">
                  {{ row.buyers }} Buyers
                </UBadge>
              </template>

              <template #action-data="{ row }">
                <UButton
                  color="black"
                  variant="ghost"
                  icon="solar:eye-outline"
                  class="mr-2"
                  :to="`/app/publishers/${row.name.toLowerCase()}`"
                />
              </template>
              <!-- custom column end -->
            </UTable>

            <div
              class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
            >
              <UPagination
                v-model="page"
                :page-count="pageCount"
                :total="categories.length"
              />
            </div>
          </div>
        </div>
        <!-- Add New category SideOver Start -->
        <USlideover v-model="is_add_category_open">
          <UCard
            class="flex flex-col flex-1 p-5 overflow-y-scroll"
            :ui="{
              body: { base: 'flex-1' },
              ring: '',
              background: 'dark:bg-transparent',
            }"
          >
            <template #header>
              <div class="flex">
                <h3 class="text-lg font-semibold">Add New Category</h3>
                <UButton
                  color="black"
                  icon="solar:close-circle-bold"
                  class="ml-auto"
                  variant="ghost"
                  @click="is_add_category_open = false"
                />
              </div>
            </template>

            <div class="my-3 flex flex-col gap-3">
              <UFormGroup label="Name" required>
                <UInput placeholder="Enter the name of the publisher" />
              </UFormGroup>
              <UFormGroup label="Cover Image" required>
                <FileUploader />
              </UFormGroup>
            </div>

            <template #footer>
              <div class="flex justify-end gap-3">
                <UButton label="Reset" color="gray" icon="solar:restart-bold" />
                <UButton
                  label="Submit"
                  color="black"
                  icon="solar:add-circle-bold"
                  @click="is_add_category_open = false"
                />
              </div>
            </template>
          </UCard>
        </USlideover>
        <!-- Add New category SideOver End -->
      </div>
    </NuxtLayout>
  </div>
</template>
