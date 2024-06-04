<script setup>
onMounted(() => {
  loadPublishers();
  formatIssuers();
});

const router = useRouter();
const isLoading = ref(false);

const is_add_issuer_open = ref(false);
const publishers = ref([]);
const logo = ref(null);
watch(logo, (value) => {
  const reader = new FileReader();
  reader.onload = function (e) {
    form.value.logo = e.target.result;
  };
  reader.readAsDataURL(value);
});

const columns = [
  {
    label: "Name",
    key: "name",
    sortable: true,
  },
  {
    label: "publishes",
    key: "publishes",
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

// const data_issuers = ref([
//   {
//     id: 1,
//     name: "DC Comics",
//     publisher: "dc",
//     last_comic: "Batman: The Long Halloween #6",
//     last_issued_at: new Date(),
//     publishes: 20,
//     buyers: 50,
//   },
//   {
//     id: 1,
//     name: "Marvel Comics",
//     publisher: "marvel",
//     last_comic: "The Amazing Spider #3",
//     last_issued_at: new Date(),
//     publishes: 30,
//     buyers: 100,
//   },
//   {
//     id: 1,
//     name: "Image Comics",
//     publisher: "image",
//     last_comic: "Spawn #1",
//     last_issued_at: new Date(),
//     publishes: 10,
//     buyers: 10,
//   },
//   {
//     id: 1,
//     name: "Dark Horse Comics",
//     publisher: "dark-horse",
//     last_comic: "Hellboy: The Corpse",
//     last_issued_at: new Date(),
//     publishes: 15,
//     buyers: 20,
//   },
//   {
//     id: 1,
//     name: "IDW Publishing",
//     publisher: "idw",
//     last_comic: "Teenage Mutant Ninja Turtles #1",
//     last_issued_at: new Date(),
//     publishes: 5,
//     buyers: 5,
//   },
//   {
//     id: 1,
//     name: "Boom! Studios",
//     publisher: "boom",
//     last_comic: "Mighty Morphin Power Rangers #1",
//     last_issued_at: new Date(),
//     publishes: 25,
//     buyers: 30,
//   },
//   {
//     id: 1,
//     name: "Dynamite Entertainment",
//     publisher: "dynamite",
//     last_comic: "The Boys #6",
//     last_issued_at: new Date(),
//     publishes: 35,
//     buyers: 40,
//   },
//   {
//     id: 1,
//     name: "Valiant Comics",
//     publisher: "valiant",
//     last_comic: "X-O Manowar #1",
//     last_issued_at: new Date(),
//     publishes: 40,
//     buyers: 60,
//   },
//   {
//     id: 1,
//     name: "Archie Comics",
//     publisher: "archie",
//     last_comic: "Archie #1",
//     last_issued_at: new Date(),
//     publishes: 45,
//     buyers: 70,
//   },
//   {
//     id: 1,
//     name: "Aftershock Comics",
//     publisher: "aftershock",
//     last_comic: "Animosity #1",
//     last_issued_at: new Date(),
//     publishes: 50,
//     buyers: 80,
//   },
// ]);

const form = ref({
  name: "",
  logo: "",
});

const page = ref(1);
const pageCount = 5;

const rows = computed(() => {
  return publishers.value.slice(
    (page.value - 1) * pageCount,
    page.value * pageCount
  );
});

async function loadPublishers() {
  isLoading.value = true;
  const { data } = await useApiFetch("/api/publishers");
  if (data) {
    publishers.value = data.publishers;
  }
  isLoading.value = false;
}

function formatIssuers() {
  publishers.value = publishers.value.map((publisher) => ({
    ...publisher,
    last_issued_at: getFormatedDate(new Date(publisher.last_issued_at)),
  }));
}

async function addPublisher() {
  const { data } = await useApiFetch("/api/publishers/create", {
    method: "POST",
    body: form.value,
  });

  if (data) {
    useNotifications().value.push({
      type: "success",
      message: "Publisher added successfully",
    });
    form.value = useFormReset(form.value);
  }
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
          <AppHeading title="Comic publishers" />

          <UButton
            label="Add An publisher"
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
                  :src="`${$config.public.apiURL}/storage${row.logo}`"
                  :alt="row.name"
                  class="h-8"
                />
                <span>{{ row.name }}</span>
              </div>
            </template>

            <template #publishes-data="{ row }">
              {{ row.publishes }} publishes
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
                :to="`/app/publishers/${row._id}`"
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
              :total="publishers.length"
            />
          </div>
        </div>

        <!-- Add New publisher SideOver Start -->
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
                <h3 class="text-lg font-semibold">Add An publisher</h3>
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
                <UInput
                  placeholder="Enter the name of the publisher"
                  v-model="form.name"
                />
              </UFormGroup>
              <UFormGroup label="Logo" required>
                <FileUploader v-model="logo" />
              </UFormGroup>
            </div>

            <template #footer>
              <div class="flex justify-end gap-3">
                <UButton label="Reset" color="gray" icon="solar:restart-bold" />
                <UButton
                  label="Submit"
                  color="black"
                  icon="solar:add-circle-bold"
                  @click="addPublisher"
                />
              </div>
            </template>
          </UCard>
        </USlideover>
        <!-- Add New publisher SideOver End -->
      </div>
    </NuxtLayout>
  </div>
</template>
