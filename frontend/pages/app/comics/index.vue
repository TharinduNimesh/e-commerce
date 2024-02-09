<script setup>
const router = useRouter();

onMounted(() => {
  updated_comics.value = updateComicsLayout(comics.value);
});

const columns = [
  {
    key: "name",
    label: "Name",
    sortable: true,
  },
  {
    key: "price",
    label: "Price",
    sortable: true,
  },
  {
    key: "buyers",
    label: "Buyers Count",
    sortable: true,
  },
  {
    key: "profit",
    label: "Total Profit",
    sortable: true,
  },
  {
    key: "created_at",
    label: "Published At",
    sortable: true,
  },
  {
    key: "updated_at",
    label: "Last Update",
  },
  {
    key: "action",
    label: "Action",
  },
];

const items = (row) => [
  [
    {
      label: "Information",
      icon: "solar:database-bold",
      click: () => router.push(`/app/comics/${row.id}`),
    },
    {
      label: "Edit",
      icon: "i-heroicons-pencil-square-20-solid",
      click: () => router.push(`/app/comics/edit/${row.id}`),
    },
  ],
  [
    {
      label: "Visit in shop",
      icon: "solar:eye-bold",
    },
  ],
  [
    {
      label: "Hide",
      icon: "ph:eye-slash-fill",
    },
    {
      label: "Delete",
      icon: "i-heroicons-trash-20-solid",
    },
  ],
];

const updated_comics = ref([]);
const comics = ref([
  {
    id: 1,
    name: "Batman The Gotham Knight #1",
    issuer: "DC",
    price: 1000,
    buyers: 10,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 2,
    name: "Spider-Man: The Amazing Adventures #1",
    issuer: "Marvel",
    price: 1200,
    buyers: 150,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 3,
    name: "Superman: Man of Steel #1",
    issuer: "DC",
    price: 900,
    buyers: 30,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 4,
    name: "X-Men: The Uncanny #1",
    issuer: "Marvel",
    price: 1100,
    buyers: 132,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 5,
    name: "Wonder Woman: The Amazon Princess #1",
    issuer: "DC",
    price: 950,
    buyers: 9,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 6,
    name: "The Flash: Speed Force #1",
    issuer: "DC",
    price: 1050,
    buyers: 11,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 7,
    name: "Iron Man: Armored Avenger #1",
    issuer: "Marvel",
    price: 1150,
    buyers: 13,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 8,
    name: "Aquaman: King of the Seas #1",
    issuer: "DC",
    price: 950,
    buyers: 9,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 9,
    name: "Captain America: The Sentinel of Liberty #1",
    issuer: "Marvel",
    price: 1000,
    buyers: 10,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 10,
    name: "Green Lantern: Emerald Guardian #1",
    issuer: "DC",
    price: 1100,
    buyers: 12,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 11,
    name: "Thor: God of Thunder #1",
    issuer: "Marvel",
    price: 1250,
    buyers: 14,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 12,
    name: "Black Widow: Deadly Origin #1",
    issuer: "Marvel",
    price: 950,
    buyers: 9,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 13,
    name: "Green Arrow: The Emerald Archer #1",
    issuer: "DC",
    price: 1000,
    buyers: 10,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 14,
    name: "The Incredible Hulk: Smash #1",
    issuer: "Marvel",
    price: 1050,
    buyers: 11,
    created_at: new Date(),
    updated_at: new Date(),
  },
  {
    id: 15,
    name: "Catwoman: The Feline Fatale #1",
    issuer: "DC",
    price: 975,
    buyers: 10,
    created_at: new Date(),
    updated_at: new Date(),
  },
]);

const page = ref(1);
const pageCount = 5;

const rows = computed(() => {
  return updated_comics.value.slice(
    (page.value - 1) * pageCount,
    page.value * pageCount
  );
});

watch(comics, (new_value) => {
  updated_comics.value = updateComicsLayout(new_value);
});

function updateComicsLayout(list) {
  return list.map((data) => ({
    ...data,
    issuer: data.issuer.toLowerCase(),
    price: `LKR ${data.price.toLocaleString("en-US")}`,
    profit: `LKR ${(data.price * data.buyers).toLocaleString("en-US")}`,
    created_at: getFormatedDate(new Date(data.created_at)),
    updated_at: getFormatedDate(new Date(data.updated_at)),
  }));
}
</script>

<template>
  <div>
    <NuxtLayout name="app">
      <div
        class="w-full p-5 lg:p-8 bg-primary-light dark:bg-primary-dark rounded-lg"
      >
        <div
          class="flex flex-col lg:flex-row items-center lg:items-start justify-between"
        >
          <AppHeading title="Your Comics" />

          <UButton
            label="Add New Comic"
            color="black"
            icon="solar:add-circle-bold"
            to="/app/comics/new"
          />
        </div>

        <div class="border border-slate-500/40 rounded-lg mt-5 px-2">
          <UTable :columns="columns" :rows="rows">
            <!-- custom columns start -->
            <template #name-data="{ row }">
              <div class="flex items-center gap-2 pr-5">
                <img
                  class="h-8"
                  :src="`/img/comics/batman-comic.png`"
                  :alt="row.issuer"
                />
                <div class="flex flex-col">
                  <h5 class="text-md">
                    {{ row.name }}
                  </h5>
                  <span class="text-xs font-semibold uppercase">
                    {{ row.issuer }}
                  </span>
                </div>
              </div>
            </template>

            <template #buyers-data="{ row }">
              <UBadge v-if="row.buyers < 20" color="red" variant="subtle">
                {{ row.buyers }} Buyers
              </UBadge>
              <UBadge
                v-else-if="row.buyers < 50"
                color="orange"
                variant="subtle"
              >
                {{ row.buyers }} Buyers
              </UBadge>
              <UBadge v-else color="green" variant="subtle">
                {{ row.buyers }} Buyers
              </UBadge>
            </template>

            <template #action-data="{ row }">
              <UDropdown :items="items(row)">
                <UButton
                  color="gray"
                  variant="ghost"
                  icon="i-heroicons-ellipsis-horizontal-20-solid"
                  class="dark:hover:bg-secondary-dark/30"
                />
              </UDropdown>
            </template>
            <!-- custom columns end -->
          </UTable>

          <div
            class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
          >
            <UPagination
              v-model="page"
              :page-count="pageCount"
              :total="updated_comics.length"
            />
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
