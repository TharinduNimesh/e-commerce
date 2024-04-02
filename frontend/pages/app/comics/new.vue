<script setup>
const is_loading = ref(false);
const image_container = ref();
const image = ref("");
watch(image, (value) => {
  if (value) {
    if (form.value.images.length >= 5) {
      useNotifications().value.push({
        type: "error",
        title: "Error",
        message: "You can only upload 5 images",
      });
      return;
    }

    form.value.images.push(value);
    image.value = "";
  }
});

const form = ref({
  name: "",
  categories: [],
  description: "",
  price: "",
  has_discount: false,
  discount: "",
  publisher: "",
  published_date: "",
  images: [],
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

function removeImage(index) {
  form.value.images.splice(index, 1);
}

function markAsPrimary(index) {
  const primary = form.value.images[index];
  form.value.images.splice(index, 1);
  form.value.images.unshift(primary);
}

async function addProduct() {
  is_loading.value = true;
  const { data } = await useApiFetch("/api/comics/create", {
    method: "POST",
    body: form.value,
  });

  if (data) {
    useNotifications().value.push({
      type: "success",
      title: "Success",
      message: "Comic added successfully",
    });
    form.value = useFormReset(form.value);
    form.value.images = [];
    form.value.categories = [];
  }
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
        <AppHeading title="Add new comic" />
        <div class="grid grid-cols-8 gap-3 mt-5">
          <div class="col-span-full md:col-span-5">
            <UFormGroup label="Name" required>
              <UInput placeholder="Name Of The Comic Book" v-model="form.name" />
            </UFormGroup>
          </div>
          <div class="col-span-full md:col-span-3">
            <UFormGroup label="Category" required>
              <USelectMenu
                searchable
                multiple
                searchable-placeholder="Search a category..."
                placeholder="Select a category"
                :options="categories"
                v-model="form.categories"
              />
            </UFormGroup>
          </div>
          <div class="col-span-full">
            <UFormGroup label="Description" required>
              <TipTap v-model="form.description" />
            </UFormGroup>
          </div>
          <div class="col-span-full md:col-span-4">
            <UFormGroup label="Price" required>
              <UInput placeholder="Enter the Price" class="rounded-l-none" v-model="form.price">
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
                :disabled="!form.has_discount"
                placeholder="Enter The Discount"
                :ui="{ icon: { leading: { pointer: '' } } }"
              >
                <template #leading>
                  <UCheckbox v-model="form.has_discount" />
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
                v-model="form.publisher"
              />
            </UFormGroup>
          </div>
          <div class="col-span-full md:col-span-4">
            <UFormGroup label="Published Date" required>
              <UInput type="date" class="rounded-l-none" v-model="form.published_date"/>
            </UFormGroup>
          </div>
          <div class="col-span-full">
            <div class="flex flex-col gap-5">
              <UFormGroup label="Images" hint="Max 5 Images" required>
                <FileUploader v-model="image" />
              </UFormGroup>
              <div class="flex gap-3 flex-wrap" ref="image_container">
                <AppImage
                  v-for="(image, index) in form.images"
                  :image="image"
                  :index="index"
                  :primary="index == 0"
                  @onremove="removeImage"
                  @onmark="markAsPrimary"
                />
              </div>
            </div>
          </div>
          <div class="col-span-full flex justify-end gap-3">
            <UButton color="gray" variant="solid" label="Clear" />
            <UButton
              color="black"
              variant="solid"
              label="Submit"
              icon="ic:round-send"
              @click="addProduct"
              trailing
            />
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
