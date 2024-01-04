<template>
  <div
    class="w-full bg-gray-100 dark:bg-secondary-dark bg-repeat-y bg-contain bg-[url(/img/shop-bg.png)]"
  >
    <!-- header -->
    <ShopHeader />

    <!-- Main Content Start -->
    <main class="w-full">
        <slot />
    </main>
    <!-- Footer -->
    <ShopFooter />
    <!-- Main Content End -->
  </div>
</template>
