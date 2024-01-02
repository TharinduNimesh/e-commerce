<script setup>
const props = defineProps(["unique"]);

let slider;
let mouseDown = false;
let startX, scrollLeft;

onMounted(() => {
  slider = document.getElementById(props.unique);
  slider.addEventListener("mousemove", move, false);
  slider.addEventListener("mousedown", startDragging, false);
  slider.addEventListener("mouseup", stopDragging, false);
  slider.addEventListener("mouseleave", stopDragging, false);
});

function startDragging(e) {
  mouseDown = true;
  startX = e.pageX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;
}

function stopDragging(e) {
  mouseDown = false;
}

function move(e) {
  e.preventDefault();
  if (!mouseDown) {
    return;
  }
  const x = e.pageX - slider.offsetLeft;
  const scroll = x - startX;
  slider.scrollLeft = scrollLeft - scroll;
}
</script>

<template>
  <div :id="unique" class="draggable w-full overflow-x-scroll flex gap-5 py-5 active:cursor-grab">
    <slot />
  </div>
</template>

<style>
.draggable::-webkit-scrollbar {
  display: none;
}

.draggable {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>