<script setup>
const mainHeight = ref(0);
onMounted(() => {
  mainHeight.value = document.getElementById("main-slot").offsetHeight;
});

const styles = computed(() => {
  if (mainHeight.value < 2000) {
    return "bg-cover";
  }
  return "bg-contain";
});
</script>

<template>
  <div
    class="w-full bg-gray-100 dark:bg-secondary-dark bg-repeat-y bg-right-top bg-[url(/img/shop-bg.png)]"
    :class="styles"
  >
    <!-- header -->
    <ShopHeader />

    <!-- Main Content Start -->
    <main id="main-slot" class="w-full">
      <slot />
    </main>
    <!-- Footer -->
    <ShopFooter />
    <!-- Main Content End -->
  </div>
</template>
