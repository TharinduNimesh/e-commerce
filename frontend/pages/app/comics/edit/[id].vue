<script setup>
const config = useRuntimeConfig();
const route = useRoute();
const is_loading = ref(false);
const is_request_sent = ref(false);
const publisher = ref("");
const publishers_data = ref([]);
const data = ref(null);
const image = ref(null);
const id = route.params.id;
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
onMounted(async () => {
  await loadPublishers();
  loadData();
});
watch(image, (newValue) => {
  if (newValue) {
    form.value.images.push(newValue);
  }
});
watch(publisher, (value) => {
  const selected_publisher = publishers_data.value.find(
    (pub) => pub.name === value
  );
  console.log(selected_publisher);
  form.value.publisher = selected_publisher?._id;
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

const publishers = ref([]);

async function loadData() {
  is_loading.value = true;
  const { data: response } = await useApiFetch(`/api/comics/${id}`, {}, false);
  if (response) {
    const comic = response.comic;
    data.value = comic;
    form.value = {
      name: comic.name,
      categories: comic.categories,
      description: comic.description,
      price: comic.price,
      has_discount: comic.has_discount,
      discount: comic.discount,
      publisher: comic.publisher._id,
      published_date: comic.issued_at,
      images: comic.images,
    };
    form.value.images = comic.images.map(
      (image) => `${config.public.apiURL}/storage/${image}`
    );
    publisher.value = comic.publisher.name;
  } else {
    data.value = "not_found";
    useNotifications().value.push({
      type: "warning",
      message: "Failed to load comic data",
    });
  }
  is_loading.value = false;
}

async function loadPublishers() {
  is_loading.value = true;
  const { data } = await useApiFetch("/api/publishers");
  if (data) {
    publishers.value = data.publishers.map(publisher => publisher.name);
    publishers_data.value = data.publishers;
  }
}

async function update() {
  is_request_sent.value = true;
  const { data } = await useApiFetch(`/api/comics/${id}`, {
    method: "PUT",
    body: form.value,
  });
  if (data) {
    useNotifications().value.push({
      type: "success",
      message: "Comic updated successfully",
    });
    useRouter().push(`/app/comics/${id}`);
  }
  is_request_sent.value = false;
}

function removeImage(index) {
  form.value.images.splice(index, 1);
}

function markAsPrimary(index) {
  const primary = form.value.images[index];
  form.value.images.splice(index, 1);
  form.value.images.unshift(primary);
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
        <div class="grid grid-cols-2 mt-5 gap-3" v-if="is_loading">
          <div class="flex flex-col gap-1">
            <USkeleton class="w-[200px] h-3" />
            <USkeleton class="w-full h-10" />
          </div>
          <div class="flex flex-col gap-1">
            <USkeleton class="w-[200px] h-3" />
            <USkeleton class="w-full h-10" />
          </div>
          <div class="col-span-full flex flex-col gap-1">
            <USkeleton class="w-[200px] h-3" />
            <USkeleton class="w-full h-[200px]" />
          </div>
          <div class="flex flex-col gap-1">
            <USkeleton class="w-[200px] h-3" />
            <USkeleton class="w-full h-10" />
          </div>
          <div class="flex flex-col gap-1">
            <USkeleton class="w-[200px] h-3" />
            <USkeleton class="w-full h-10" />
          </div>
          <div class="flex flex-col gap-1">
            <USkeleton class="w-[200px] h-3" />
            <USkeleton class="w-full h-10" />
          </div>
          <div class="flex flex-col gap-1">
            <USkeleton class="w-[200px] h-3" />
            <USkeleton class="w-full h-10" />
          </div>
          <div class="col-span-full flex flex-col gap-1">
            <USkeleton class="w-[200px] h-3" />
            <USkeleton class="w-full h-[200px]" />
          </div>
        </div>
        <div
          v-else-if="data == 'not_found' || data == null"
          class="w-full flex flex-col"
        >
          <div class="w-full flex flex-col items-center">
            <h1
              class="text-4xl uppercase text-gradient from-green-600 dark:from-green-700 to-violet-500 dark:to-violet-500 font-extrabold"
            >
              Comic Not Fount
            </h1>
            <span class="text-lg font-bold text-center">
              We couldn't find the comic you are looking for, please try
              refreshing the page or
              <ULink
                @click="$router.back()"
                active-class="text-primary"
                inactive-class="text-primary"
              >
                Go Back </ULink
              >.
            </span>
          </div>
        </div>
        <div class="grid grid-cols-8 gap-3 mt-5" v-else>
          <div class="col-span-full md:col-span-5">
            <UFormGroup label="Name" required>
              <UInput
                placeholder="Name Of The Comic Book"
                v-model="form.name"
              />
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
              <UInput
                placeholder="Enter the Price"
                class="rounded-l-none"
                v-model="form.price"
              >
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
                v-model="form.discount"
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
                v-model="publisher"
              />
            </UFormGroup>
          </div>
          <div class="col-span-full md:col-span-4">
            <UFormGroup label="Published Date" required>
              <UInput
                type="date"
                class="rounded-l-none"
                v-model="form.published_date"
              />
            </UFormGroup>
          </div>
          <div class="col-span-full">
            <div class="flex flex-col gap-5">
              <UFormGroup label="Images" hint="Max 5 Images" required>
                <FileUploader v-model="image" />
              </UFormGroup>
              <div class="flex gap-3 flex-wrap">
                <AppImage
                  v-for="(image, index) in form.images"
                  :key="image"
                  :image="image"
                  :index="index"
                  :primary="index == 0"
                  @onremove="removeImage"
                  @onmark="markAsPrimary"
                />
              </div>
            </div>
          </div>
          <div class="col-span-full flex justify-center md:justify-end gap-3">
            <UButton @click="$router.back" color="gray" variant="solid" label="Discard" />
            <UButton
              color="black"
              variant="solid"
              label="Save Changes"
              icon="ic:round-send"
              :loading="is_request_sent"
              trailing
              @click="update"
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
