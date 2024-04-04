<script setup>
const route = useRoute();
const is_loading = ref(false);
const is_rate_open = ref(false);
const is_favorite = ref(false);
const data = ref(null);
const id = route.params.id;
const active_image = ref(null);
onMounted(async () => {
  await loadData();
  if (data.value != "not_found") {
    active_image.value = data.value.images[0];
  }
});

function calculatePrice() {
  if (data?.value && data?.value?.has_discount) {
    let price = parseFloat(data.value.price);
    let offer = parseFloat(data.value.discount);
    return (price - (price * offer) / 100).toFixed(2);
  }
}

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

const selected_emoji = ref(0);

const emojis = [
  {
    label: "Very Bad",
    emoji: "😡",
  },
  {
    label: "Bad",
    emoji: "😠",
  },
  {
    label: "Okay",
    emoji: "😐",
  },
  {
    label: "Good",
    emoji: "😊",
  },
  {
    label: "Very Good",
    emoji: "😍",
  },
];
const comments = [
  {
    id: 1,
    name: "BatmanFan87",
    time: "2024-01-18T10:05:00",
    comment:
      "Incredible storytelling and a bold reimagining of Batman. Miller's genius shines through every panel.",
  },
  {
    id: 2,
    name: "ComicGeek42",
    time: "2024-01-18T10:30:00",
    comment:
      "The Dark Knight Returns #1 is a masterpiece, with a gripping narrative and stunning artwork that stands the test of time.",
  },
  {
    id: 3,
    name: "GothamKnight",
    time: "2024-01-18T11:15:00",
    comment:
      "A revolutionary take on Batman that delves into the darker corners of the character's psyche. Miller's vision is unmatched.",
  },
  {
    id: 4,
    name: "ArtConnoisseur",
    time: "2024-01-18T11:45:00",
    comment:
      "Klaus Janson's art complements Frank Miller's writing perfectly, creating a visually stunning and emotionally impactful experience.",
  },
  {
    id: 5,
    name: "SuperheroBuff",
    time: "2024-01-18T12:20:00",
    comment:
      "This comic is a game-changer. It brought a new level of depth and complexity to superhero storytelling.",
  },
  {
    id: 6,
    name: "BatObsessed",
    time: "2024-01-18T13:00:00",
    comment:
      "Frank Miller's exploration of an older Batman is both gritty and thought-provoking. A must-read for any Bat-fan.",
  },
  {
    id: 7,
    name: "GraphicNovelAficionado",
    time: "2024-01-18T13:30:00",
    comment:
      "The Dark Knight Returns #1 is a landmark in the evolution of graphic storytelling. It's raw, intense, and unforgettable.",
  },
  {
    id: 8,
    name: "DCDevotee",
    time: "2024-01-18T14:10:00",
    comment:
      "This comic captures the essence of Batman's legacy and the impact of his return. A true classic!",
  },
  {
    id: 9,
    name: "ComicExplorer",
    time: "2024-01-18T14:45:00",
    comment:
      "A cinematic experience on paper. The narrative is compelling, and the artwork is nothing short of spectacular.",
  },
  {
    id: 10,
    name: "BaneBane",
    time: "2024-01-18T15:20:00",
    comment:
      "Miller's take on an older, battle-worn Batman is nothing short of brilliant. The Dark Knight Returns is a triumph.",
  },
  {
    id: 11,
    name: "JokerFanatic",
    time: "2024-01-18T16:00:00",
    comment:
      "An iconic clash between Batman and the Joker that left me on the edge of my seat. The tension is palpable.",
  },
  {
    id: 12,
    name: "NostalgicReader",
    time: "2024-01-18T16:30:00",
    comment:
      "Reading this comic feels like revisiting a classic. It's a timeless piece of Batman history that never gets old.",
  },
  {
    id: 13,
    name: "HeroicHues",
    time: "2024-01-18T17:15:00",
    comment:
      "The artwork's use of shadows and contrasts adds a layer of depth that enhances the overall mood of the story.",
  },
  {
    id: 14,
    name: "ArkhamRegular",
    time: "2024-01-18T17:45:00",
    comment:
      "A thrilling exploration of the consequences of a retired Batman returning to the chaos of Gotham. Gripping from start to finish.",
  },
  {
    id: 15,
    name: "GraphicNovelGuru",
    time: "2024-01-18T18:20:00",
    comment:
      "This comic set the standard for mature and complex storytelling in superhero comics. A game-changer.",
  },
  {
    id: 16,
    name: "BatCollector",
    time: "2024-01-18T19:00:00",
    comment:
      "The Dark Knight Returns #1 is a cornerstone of any Batman collection. Miller's narrative is iconic and unforgettable.",
  },
  {
    id: 17,
    name: "WonderReader",
    time: "2024-01-18T19:30:00",
    comment:
      "A masterclass in character development. Batman's internal struggles are portrayed with depth and authenticity.",
  },
  {
    id: 18,
    name: "PanelPundit",
    time: "2024-01-18T20:15:00",
    comment:
      "A visually stunning and emotionally charged journey into the heart of Gotham. Miller and Janson are a dynamic duo.",
  },
  {
    id: 19,
    name: "DarkComicAficionado",
    time: "2024-01-18T20:45:00",
    comment:
      "The Dark Knight Returns #1 is a gritty, intense, and unforgettable chapter in Batman's legacy. A true masterpiece.",
  },
  {
    id: 20,
    name: "CapedObserver",
    time: "2024-01-18T21:30:00",
    comment:
      "An absolute triumph that elevated the superhero genre. The impact of this comic is felt even decades later.",
  },
];

const page = ref(1);
const displayed_comments = computed(() => {
  const start = (page.value - 1) * 5;
  const end = page.value * 5;
  return comments.slice(start, end);
});

function addToCart() {
  const status = useCartStore().add(data.value._id);
  if (status == "added") {
    useNotifications().value.push({
      type: "success",
      message: "Comic added to cart",
    });
    return;
  }
  useNotifications().value.push({
    type: "warning",
    message: "Comic already in cart",
  });
}
</script>

<template>
  <div>
    <NuxtLayout name="shop">
      <div class="w-full flex flex-col items-center pt-20">
        <div class="w-full p-10" v-if="!data">
          <AppProductSkeleton />
        </div>
        <div v-else-if="data == 'not_found'" class="w-full flex flex-col">
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
        <section v-else class="container flex flex-col flex-wrap min-h-screen">
          <div
            class="w-full flex justify-end cursor-pointer my-3 px-5"
            @click="is_favorite = !is_favorite"
          >
            <Icon
              v-if="is_favorite"
              name="i-heroicons-heart-20-solid"
              class="text-2xl text-red-500 dark:text-red-400"
            />
            <Icon
              v-else
              name="i-heroicons-heart"
              class="text-2xl text-red-500 dark:text-red-400"
            />
          </div>
          <div class="w-full flex gap-5 lg:gap-0 flex-wrap">
            <div
              class="relative w-full flex flex-col justify-center items-center lg:w-1/2"
            >
              <div
                :class="{
                  'hidden lg:flex': active_image != data.images[0],
                }"
                class="absolute w-[80px] top-0 left-0"
              >
                <img
                  :src="`${$config.public.apiURL}/storage/${data.publisher.logo}`"
                  alt="DC Studios"
                  class="w-full"
                />
              </div>
              <div class="w-4/5 max-w-[500px]">
                <img
                  :src="`${$config.public.apiURL}/storage${active_image}`"
                  alt="Batman Comic Cover"
                  class="w-full max-h-[400px] object-contain"
                />
              </div>
              <div
                class="h-[80px] flex gap-1 mt-5 w-full overflow-x-scroll overflow-y-hidden"
              >
                <div
                  v-for="image in data.images"
                  :key="image"
                  class="h-full flex-none cursor-pointer duration-300 hover:scale-105"
                  @click="active_image = image"
                >
                  <img
                    v-show="image != active_image"
                    :src="`${$config.public.apiURL}/storage${image}`"
                    alt="Batman Comic Cover"
                    class="h-full"
                  />
                </div>
              </div>
            </div>
            <div class="w-full flex flex-col lg:w-1/2 px-5">
              <div class="flex flex-col w-full max-w-[700px]">
                <h1
                  class="text-3xl font-bold uppercase text-gray-700 dark:text-slate-100"
                >
                  {{ data.name }}
                </h1>
                <span
                  class="text-lg font-semibold uppercase text-gray-400 dark:text-slate-400"
                >
                  {{ data.publisher.name }}
                </span>
              </div>
              <div class="flex justify-center py-5">
                <div class="grid grid-cols-3 w-full">
                  <div class="col-span-1 flex flex-col items-center gap-1">
                    <Icon
                      name="material-symbols-light:kid-star-sharp"
                      class="text-2xl"
                    />
                    <span class="text-gray-700 dark:text-slate-100"
                      >8.5/10</span
                    >
                  </div>
                  <div class="col-span-1 flex flex-col items-center gap-1">
                    <Icon
                      name="heroicons:shopping-cart-20-solid"
                      class="text-2xl"
                    />
                    <span class="text-gray-700 dark:text-slate-100"
                      >1, 100</span
                    >
                  </div>
                  <div class="col-span-1 flex flex-col items-center gap-1">
                    <Icon name="i-heroicons-heart-solid" class="text-2xl" />
                    <span class="text-gray-700 dark:text-slate-100"
                      >3, 400</span
                    >
                  </div>
                </div>
              </div>
              <div
                class="text-gray-500 dark:text-gray-400"
                v-html="data.description"
              />
              <div class="w-full flex flex-col gap-3">
                <div class="w-full flex mt-5 py-2">
                  <span v-if="data.has_discount">
                    <span
                      class="line-through text-red-500 dark:text-red-400 text-sm"
                      >LKR. {{ data.price }}</span
                    >
                    <span
                      class="text-green-500 dark:text-green-600 font-semibold text-xl"
                      >LKR. {{ calculatePrice() }}</span
                    >
                  </span>
                  <span
                    v-else
                    class="font-semibold text-xl text-gray-500 dark:text-gray-400"
                    >LKR. {{ data.price }}</span
                  >
                </div>
                <div class="w-full grid grid-cols-12 gap-3">
                  <div
                    class="col-span-full md:col-span-6 lg:col-span-8 xl:col-span-9"
                  >
                    <UButton
                      color="indigo"
                      block
                      size="lg"
                      class="uppercase"
                      label="Add To Cart"
                      icon="i-heroicons-shopping-cart-20-solid"
                      @click="addToCart"
                    />
                  </div>
                  <div
                    class="col-span-full md:col-span-6 lg:col-span-4 xl:col-span-3"
                  >
                    <UButton
                      color="orange"
                      block
                      size="lg"
                      class="uppercase"
                      label="Rate This"
                      icon="material-symbols-light:kid-star-sharp"
                      @click="is_rate_open = true"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="container flex flex-col p-5">
          <h2 class="text-3xl font-bold uppercase">20 Comments</h2>
          <div class="w-full grid grid-cols-12 md:px-10 lg:px-12 mt-10">
            <div class="col-span-8 md:col-span-10">
              <UInput
                size="xl"
                placeholder="Write a comment..."
                class="rounded-none rounded-l"
              />
            </div>
            <div class="col-span-4 md:col-span-2">
              <UButton
                color="indigo"
                size="xl"
                class="rounded-none rounded-r"
                label="Comment"
                icon="i-material-symbols-send-rounded"
                block
                trailing
              />
            </div>
          </div>
          <div class="w-full flex flex-col gap-1 mt-5">
            <Comment
              v-for="comment in displayed_comments"
              :key="comment.comment"
              :name="comment.name"
              :date="comment.time"
              :comment="comment.comment"
            />
            <div class="flex justify-end">
              <UPagination
                v-model="page"
                :page-count="5"
                :total="comments.length"
              />
            </div>
          </div>
        </section>
      </div>

      <!-- Rate This Modal Start -->
      <UModal v-model="is_rate_open">
        <UCard
          :ui="{
            ring: '',
            divide: 'divide-y divide-gray-100 dark:divide-gray-800',
          }"
        >
          <template #header>
            <div class="flex justify-between">
              <h2 class="text-xl font-bold uppercase">Rate This Comic</h2>
              <Icon
                name="heroicons:x-mark-16-solid"
                class="text-2xl cursor-pointer"
                @click="is_rate_open = false"
              />
            </div>
          </template>
          <div class="flex gap-3 flex-col">
            <UFormGroup label="Rate" required>
              <div class="flex justify-center">
                <div class="flex gap-3">
                  <div v-for="(emoji, index) in emojis" :key="emoji.emoji">
                    <span
                      class="text-4xl cursor-pointer"
                      :class="{
                        'opacity-50': selected_emoji != index,
                        'opacity-100': selected_emoji == index,
                      }"
                      @click="selected_emoji = index"
                    >
                      {{ emoji.emoji }}
                    </span>
                  </div>
                </div>
              </div>
            </UFormGroup>
            <UFormGroup label="Comment" hint="Optional">
              <UTextarea
                color="gray"
                variant="outline"
                placeholder="Your Comment ...."
              />
            </UFormGroup>
          </div>
          <template #footer>
            <div class="flex justify-end">
              <UButton
                color="indigo"
                size="lg"
                class="uppercase"
                label="Submit"
                @click="is_rate_open = false"
              />
            </div>
          </template>
        </UCard>
      </UModal>
      <!-- Rate This Modal End -->
    </NuxtLayout>
  </div>
</template>
