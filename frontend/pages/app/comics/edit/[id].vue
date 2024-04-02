<script setup>
const route = useRoute();
const description = ref("");
const has_discount = ref(false);
const is_loading = ref(false);
const data = ref(null);
const id = route.params.id;
onMounted(async () => {
  await loadData();
});

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

const publishers = [
  "DC Comics",
  "Marvel Comics",
  "Image Comics",
  "Dark Horse Comics",
  "IDW Publishing",
  "Dynamite Entertainment",
  "BOOM! Studios",
  "Valiant Comics",
  "Archie Comics",
  "Oni Press",
  "Top Cow Productions",
  "Avatar Press",
  "Zenescope Entertainment",
  "Aspen MLT",
  "Action Lab Entertainment",
  "Aftershock Comics",
  "Abstract Studio",
  "Aardvark-Vanaheim",
  "AC Comics",
];

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
        <UDivider class="my-2" />
        <AppHeading title="Edit This comic" />
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
              <TipTap v-model="description" />
            </UFormGroup>
          </div>
          <div class="col-span-full md:col-span-4">
            <UFormGroup label="Price" required>
              <UInput placeholder="Enter the Price" class="rounded-l-none">
                <template #leading>
                  <span class="text-gray-500 dark:text-gray-400 text-sm"
                    >LKR</span
                  >
                </template>
              </UInput>
            </UFormGroup>
          </div>
          <div class="col-span-full md:col-span-4">
            <UFormGroup label="Discount">
              <UInput
                :disabled="!has_discount"
                placeholder="Enter The Discount"
                :ui="{ icon: { leading: { pointer: '' } } }"
              >
                <template #leading>
                  <UCheckbox v-model="has_discount" />
                </template>
              </UInput>
            </UFormGroup>
          </div>
          <div class="col-span-full md:col-span-4">
            <UFormGroup label="Publisher" required>
              <USelectMenu
                searchable
                searchable-placeholder="Search a category..."
                placeholder="Select a category"
                :options="publishers"
                model-value="DC Comics"
              />
            </UFormGroup>
          </div>
          <div class="col-span-full md:col-span-4">
            <UFormGroup label="Published Date" required>
              <UInput type="date" class="rounded-l-none" />
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
          <div class="col-span-full flex justify-center md:justify-end gap-3">
            <UButton color="gray" variant="solid" label="Discard" />
            <UButton
              color="black"
              variant="solid"
              label="Save Changes"
              icon="ic:round-send"
              trailing
            />
          </div>
          <div
            class="col-span-full italic flex flex-col text-gray-400 dark:text-gray-500 items-end mt-5 gap-2"
          >
            <span>
              Created At : {{ getFormatedDate(new Date("2023-12-01")) }}
            </span>
            <span>
              Last Update : {{ getFormatedDate(new Date("2024-01-04")) }}
            </span>
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
