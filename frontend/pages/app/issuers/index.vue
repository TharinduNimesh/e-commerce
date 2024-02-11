<script setup>
onMounted(() => {
  formatIssuers();
});

const is_add_issuer_open = ref(false);
const issuers = ref([]);

const columns = [
  {
    label: "Name",
    key: "name",
    sortable: true,
  },
  {
    label: "Issues",
    key: "issues",
    sortable: true,
  },
  {
    label: "Buyers",
    key: "buyers",
    sortable: true,
  },
  {
    label: "Last Comic ",
    key: "last_comic",
  },
  {
    label: "Last Comic Issued At",
    key: "last_issued_at",
    sortable: true,
  },
  {
    label: "Action",
    key: "action",
    sortable: false,
  },
];

const data_issuers = ref([
  {
    name: "DC Comics",
    issuer: "dc",
    last_comic: "Batman: The Long Halloween #6",
    last_issued_at: new Date(),
    issues: 20,
    buyers: 50,
  },
  {
    name: "Marvel Comics",
    issuer: "marvel",
    last_comic: "The Amazing Spider #3",
    last_issued_at: new Date(),
    issues: 30,
    buyers: 100,
  },
  {
    name: "Image Comics",
    issuer: "image",
    last_comic: "Spawn #1",
    last_issued_at: new Date(),
    issues: 10,
    buyers: 10,
  },
  {
    name: "Dark Horse Comics",
    issuer: "dark-horse",
    last_comic: "Hellboy: The Corpse",
    last_issued_at: new Date(),
    issues: 15,
    buyers: 20,
  },
  {
    name: "IDW Publishing",
    issuer: "idw",
    last_comic: "Teenage Mutant Ninja Turtles #1",
    last_issued_at: new Date(),
    issues: 5,
    buyers: 5,
  },
  {
    name: "Boom! Studios",
    issuer: "boom",
    last_comic: "Mighty Morphin Power Rangers #1",
    last_issued_at: new Date(),
    issues: 25,
    buyers: 30,
  },
  {
    name: "Dynamite Entertainment",
    issuer: "dynamite",
    last_comic: "The Boys #6",
    last_issued_at: new Date(),
    issues: 35,
    buyers: 40,
  },
  {
    name: "Valiant Comics",
    issuer: "valiant",
    last_comic: "X-O Manowar #1",
    last_issued_at: new Date(),
    issues: 40,
    buyers: 60,
  },
  {
    name: "Archie Comics",
    issuer: "archie",
    last_comic: "Archie #1",
    last_issued_at: new Date(),
    issues: 45,
    buyers: 70,
  },
  {
    name: "Aftershock Comics",
    issuer: "aftershock",
    last_comic: "Animosity #1",
    last_issued_at: new Date(),
    issues: 50,
    buyers: 80,
  },
]);
const items = (row) => [
  [
    {
      label: "Information",
      icon: "solar:database-bold",
      click: () => router.push(`/app/comics/${row.id}`),
    },
  ],
  [
    {
      label: "Edit",
      icon: "i-heroicons-pencil-square-20-solid",
      click: () => router.push(`/app/comics/edit/${row.id}`),
    },
  ],
];

watch(data_issuers, (new_value) => {
  formatIssuers();
});

const page = ref(1);
const pageCount = 5;

const rows = computed(() => {
  return issuers.value.slice(
    (page.value - 1) * pageCount,
    page.value * pageCount
  );
});

function formatIssuers() {
  issuers.value = data_issuers.value.map((issuer) => ({
    ...issuer,
    last_issued_at: getFormatedDate(new Date(issuer.last_issued_at)),
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
          <AppHeading title="Comic Issuers" />

          <UButton
            label="Add An Issuer"
            color="black"
            icon="solar:add-circle-bold"
            @click="is_add_issuer_open = true"
          />
        </div>

        <div class="border border-slate-500/40 rounded-lg mt-5 px-2">
          <UTable :columns="columns" :rows="rows">
            <!-- custom columns start -->
            <template #name-data="{ row }">
              <div class="flex items-center gap-3">
                <img
                  :src="`/img/brands/dc.png`"
                  :alt="row.name"
                  class="h-8 rounded-full"
                />
                <span>{{ row.name }}</span>
              </div>
            </template>

            <template #issues-data="{ row }">
                {{ row.issues }} Issues
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
              <UDropdown :items="items(row)">
                <UButton
                  color="gray"
                  variant="ghost"
                  icon="i-heroicons-ellipsis-horizontal-20-solid"
                  class="dark:hover:bg-secondary-dark/30"
                />
              </UDropdown>
            </template>
            <!-- custom column end -->
          </UTable>

          <div
            class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
          >
            <UPagination
              v-model="page"
              :page-count="pageCount"
              :total="issuers.length"
            />
          </div>
        </div>

        <!-- Add New Issuer SideOver Start -->
        <USlideover v-model="is_add_issuer_open">
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
                <h3 class="text-lg font-semibold">Add An Issuer</h3>
                <UButton
                  color="black"
                  icon="solar:close-circle-bold"
                  class="ml-auto"
                  variant="ghost"
                  @click="is_add_issuer_open = false"
                />
              </div>
            </template>

            <div class="my-3 flex flex-col gap-3">
              <UFormGroup label="Name" required>
                <UInput placeholder="Enter the name of the issuer" />
              </UFormGroup>
              <UFormGroup label="Logo" required>
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
                  @click="is_add_issuer_open = false"
                />
              </div>
            </template>
          </UCard>
        </USlideover>
        <!-- Add New Issuer SideOver End -->
      </div>
    </NuxtLayout>
  </div>
</template>
