<script setup>
const color = useColorMode();

onMounted(() => {
  window.addEventListener("keyup", (event) => {
    keyHandler(event);
  });
});

function keyHandler(event) {
  // update theme on ctrl + enter
  if (event.ctrlKey && event.key === "Enter") {
    changeTheme();
  }
}

function changeTheme() {
  if (color.preference === "light") {
    color.preference = "dark";
  } else {
    color.preference = "light";
  }
}
</script>

<template>
  <div>
    <NuxtPage />
  </div>
</template>
