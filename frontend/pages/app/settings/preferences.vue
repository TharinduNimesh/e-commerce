<script setup>
const color = useColorMode();

function changeTheme(theme) {
  color.preference = theme;
}
</script>

<template>
  <div>
    <NuxtLayout name="settings">
      <div
        class="bg-primary-light-transparent dark:bg-primary-dark-transparent p-5 lg:p-8 shadow-lg rounded-lg dark:shadow-black"
      >
        <div class="w-full mb-3">
          <h3 class="text-xl font-semibold text-gray-700 dark:text-slate-200">
            Preferences
          </h3>
          <p class="text-gray-500 dark:text-slate-400">
            Personalize your ComicCage experience! Select your preferred
            theme—Dark, Light, or System default—for a customized and enjoyable
            browsing journey.
          </p>
        </div>
        <div class="grid grid-cols-2 gap-3 md:gap-0">
          <div
            class="col-span-full lg:col-span-1 flex justify-center items-center"
          >
            <img
              src="/img/miles-morales.png"
              alt="Avatar"
              class="max-w-[300px]"
            />
          </div>
          <div class="col-span-full lg:col-span-1 grid grid-cols-2 gap-3">
            <div class="col-span-full md:col-span-1 flex flex-col items-center">
              <div
                class="w-full md:max-w-[200px] cursor-pointer rounded-lg p-1"
                :class="{
                  'border border-gray-500 dark:border-slate-200':
                    $colorMode.value != 'light',
                  'border-2 border-indigo-500': $colorMode.value == 'light',
                }"
                @click="changeTheme('light')"
              >
                <img
                  src="/img/prefer-light.png"
                  alt="Light Theme"
                  class="w-full overflow-hidden"
                />
              </div>
              <span
                class="uppercase text-sm font-semibold text-gray-500 dark:text-slate-300"
              >
                Light
              </span>
            </div>
            <div class="col-span-full md:col-span-1">
              <div
                class="col-span-full md:col-span-1 flex flex-col items-center"
              >
                <div
                  class="w-full md:max-w-[200px] cursor-pointer rounded-lg p-1"
                  :class="{
                    'border border-gray-500 dark:border-slate-200':
                      $colorMode.value != 'dark',
                    'border-2 border-indigo-500': $colorMode.value == 'dark',
                  }"
                  @click="changeTheme('dark')"
                >
                  <img
                    src="/img/prefer-dark.png"
                    alt="Dark Theme"
                    class="w-full overflow-hidden"
                  />
                </div>
                <span
                  class="uppercase text-sm font-semibold text-gray-500 dark:text-slate-300"
                >
                  Dark
                </span>
              </div>
            </div>
            <div class="col-span-full md:flex justify-center">
              <div
                class="col-span-full md:col-span-1 flex flex-col items-center"
              >
                <div
                  class="w-full md:max-w-[200px] cursor-pointer rounded-lg p-1"
                  :class="{
                    'border border-gray-500 dark:border-slate-200':
                      $colorMode.value != 'system',
                    'border-2 border-indigo-500': $colorMode.value == 'system',
                  }"
                  @click="changeTheme('system')"
                >
                  <img
                    src="/img/prefer-system.png"
                    alt="Light Theme"
                    class="w-full overflow-hidden"
                  />
                </div>
                <span
                  class="uppercase text-sm font-semibold text-gray-500 dark:text-slate-300"
                >
                  System
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
