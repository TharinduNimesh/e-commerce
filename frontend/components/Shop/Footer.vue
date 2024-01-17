<script setup>
const pages = [
  {
    name: "Home",
    path: "/",
  },
  {
    name: "Shop",
    path: "/shop",
  },
  {
    name: "Category",
    path: "/category",
  },
  {
    name: "Latest",
    path: "/latest",
  },
  {
    name: "Support",
    path: "/support",
  },
  {
    name: "Register",
    path: "/register",
  },
  {
    name: "Login",
    path: "/login",
  },
];

const categories = [
  {
    name: "Action",
    path: "/category/action",
  },
  {
    name: "Fantasy",
    path: "/category/fantasy",
  },
  {
    name: "Horror",
    path: "/category/horror",
  },
  {
    name: "Mystery",
    path: "/category/mystery",
  },
  {
    name: "Superhero",
    path: "/category/romance",
  },
  {
    name: "Sci-Fi",
    path: "/category/sci-fi",
  },
  {
    name: "Thriller",
    path: "/category/thriller",
  },
];

const is_loading = ref(false);
const email = ref("");

async function subscribe() {
  if (is_loading.value) return;
  is_loading.value = true;
  if (email.value === "") {
    useNotifications().value.notifications.push({
      title: "Error",
      message: "Please enter your email address",
      type: "error",
    });
    is_loading.value = false;
    return;
  }

  const { data } = await useApiFetch("/api/newsletter", {
    method: "POST",
    body: {
      email: email.value,
    },
  });

  if (data) {
    useNotifications().value.notifications.push({
      title: "Congratulations 🎉",
      message: "You have successfully subscribed to our newsletter",
    });
    email.value = "";
  }

  is_loading.value = false;
}
</script>

<template>
  <!-- Footer Start -->
  <footer class="flex flex-col p-5 mt-[100px]">
    <div
      class="relative flex flex-col pt-[200px] lg:pt-[150px] w-full rounded-xl bg-primary-light dark:bg-primary-dark p-5 border border-violet-300 dark:border-violet-900 bg-cover md:bg-contain bg-no-repeat bg-right-bottom bg-[url(/img/cover.png)]"
    >
      <!-- Newsletter Start -->
      <div
        class="absolute flex flex-col items-center p-3 md:p-8 -top-[100px] w-10/12 md:w-3/5 left-[8.33333%] md:left-[20%] bg-primary-light dark:bg-primary-dark border-violet-300 border dark:border-violet-900 rounded-xl"
      >
        <h2
          class="text-2xl lg:text-3xl font-bold text-center text-gray-700 dark:text-gray-300 uppercase"
        >
          Subscribe to our
          <span class="text-gradient from-blue-500 via-green-500 to-violet-600"
            >newsletter</span
          >
        </h2>
        <p class="text-center text-gray-600 dark:text-gray-400 mt-2">
          Subscribe to our newsletter for exclusive previews,
          latest releases, and insider updates. Join the ComicCage community and
          stay ahead in the world of digital comics!
        </p>
        <div class="flex mt-5 w-full md:w-2/3">
          <input
            v-model="email"
            type="email"
            placeholder="Enter Your Email Address"
            class="w-full h-12 border border-gray-300 dark:border-gray-700 rounded-l px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-300 dark:focus:ring-gray-700"
          />
          <UButton
            :loading="is_loading"
            label="Subscribe"
            size="md"
            color="indigo"
            class="rounded-none rounded-r px-5"
            @click="subscribe"
          />
        </div>
      </div>
      <!-- Newsletter End -->

      <!-- Footer Content Start -->
      <div class="w-full grid grid-cols-3 gap-y-5 lg:gap-y-0">
        <div
          class="col-span-full lg:col-span-1 flex md:hidden lg:flex items-center flex-col order-2 lg:order-1"
        >
          <h3 class="text-xl font-bold uppercase">Pages</h3>
          <div class="mt-5">
            <NuxtLink
              v-for="page in pages"
              :key="page.path"
              :to="page.path"
              class="flex gap-2 mt-1 items-center text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:translate-x-1 cursor-pointer duration-300"
            >
              <Icon name="ic:baseline-keyboard-arrow-right" />
              <span>{{ page.name }} Page</span>
            </NuxtLink>
          </div>
        </div>
        <div
          class="col-span-full lg:col-span-1 flex flex-col items-center text-center order-1 lg:order-2"
        >
          <div class="flex items-center gap-5">
            <img src="/img/logo.png" class="w-[100px]" alt="ComicCage Logo" />
            <div class="flex">
              <h2
                class="text-3xl text-gradient font-extrabold from-blue-500 via-green-400 to-indigo-700"
              >
                ComicCage
              </h2>
              <span class="text-black dark:text-white self-start">&trade;</span>
            </div>
          </div>
          <p class="text-gray-600 dark:text-gray-400 mt-4">
            ComicCage is a digital comic book platform that allows you to
            discover, buy, and read comics. ComicCage is committed to bringing
            you the best digital comics and graphic novels across all genres.
          </p>
        </div>
        <div
          class="col-span-full lg:col-span-1 flex md:hidden lg:flex items-center flex-col order-3"
        >
          <h3 class="text-xl font-bold uppercase">Categories</h3>
          <div class="mt-5">
            <NuxtLink
              v-for="category in categories"
              :key="category.path"
              :to="category.path"
              class="flex gap-2 mt-1 items-center text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:translate-x-1 cursor-pointer duration-300"
            >
              <Icon name="ic:baseline-keyboard-arrow-right" />
              <span>{{ category.name }} Comics</span>
            </NuxtLink>
          </div>
        </div>
        <div class="hidden col-span-full md:grid grid-cols-2 lg:hidden order-2">
          <div class="flex flex-col items-center">
            <h3 class="text-xl font-bold uppercase">Pages</h3>
            <div class="mt-5">
              <NuxtLink
                v-for="page in pages"
                :key="page.path"
                :to="page.path"
                class="flex gap-2 mt-1 items-center text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:translate-x-1 cursor-pointer duration-300"
              >
                <Icon name="ic:baseline-keyboard-arrow-right" />
                <span>{{ page.name }} Page</span>
              </NuxtLink>
            </div>
          </div>
          <div class="flex flex-col items-center">
            <h3 class="text-xl font-bold uppercase">Categories</h3>
            <div class="mt-5">
              <NuxtLink
                v-for="category in categories"
                :key="category.path"
                :to="category.path"
                class="flex gap-2 mt-1 items-center text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:translate-x-1 cursor-pointer duration-300"
              >
                <Icon name="ic:baseline-keyboard-arrow-right" />
                <span>{{ category.name }} Comics</span>
              </NuxtLink>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer Content End -->

      <UDivider class="py-3" />

      <!-- Credits Start -->
      <div
        class="w-full flex flex-col md:flex-row justify-center md:justify-between text-center md:text-left pt-2"
      >
        <p>Design And Developed By <strong>Tharindu Nimesh</strong></p>
        <p>
          &copy; Copyright 2024 <strong>Tharindu Nimesh</strong>. Alright
          Reserved.
        </p>
      </div>
      <!-- Credits End -->
    </div>
  </footer>
  <!-- Footer End -->
</template>
