<script setup>
defineProps({
  type: {
    type: String,
    default: "success",
  },
  title: {
    type: String,
    default: undefined,
  },
  message: String,
});

function closeToast(event) {
  const toast = event.target.closest(".toast");
  toast.remove();
}
</script>

<template>
  <div
    class="toast mb-3 flex-col min-w-[300px] max-w-[500px] bg-gradient-to-r to-60% bg-[#f2f2f2] dark:bg-[#0d1217] rounded border border-blue-100 dark:border-blue-950 shadow-lg dark:shadow-black z-50"
    :class="{
      'from-green-100 dark:from-green-900': type === 'success',
      'from-red-100 dark:from-red-900': type === 'error',
      'from-orange-100 dark:from-orange-900': type === 'warning',
      'from-blue-100 dark:from-blue-900': type === 'info',
    }"
    :data-created-at="new Date()"
  >
    <div class="w-full flex justify-between">
      <div class="flex">
        <div class="flex items-center px-3">
          <Icon
            v-if="type === 'success'"
            name="ph:check-circle-fill"
            class="text-xl text-green-600 dark:text-green-400"
          />
          <Icon
            v-else-if="type === 'error'"
            name="mdi:alert-circle"
            class="text-xl text-red-600 dark:text-red-400"
          />
          <Icon
            v-else-if="type === 'warning'"
            name="mdi:alert"
            class="text-xl text-orange-600 dark:text-orange-400"
          />
          <Icon
            v-else-if="type === 'info'"
            name="mdi:information"
            class="text-xl text-blue-600 dark:text-blue-400"
          />
        </div>
        <div class="h-full flex flex-col p-2">
          <div class="w-full">
            <h6
              class="uppercase text-sm font-semibold"
              v-text="title || type"
            ></h6>
          </div>
          <div class="w-full">
            <span class="text-[13px] text-gray-500 dark:text-gray-300">
              {{ message }}
            </span>
          </div>
        </div>
      </div>
      <div
        class="flex items-center px-3 cursor-pointer"
        @click="closeToast($event)"
      >
        <Icon name="mdi:window-close" />
      </div>
    </div>
    <div
      class="time w-0 h-1 rounded-b"
      :class="{
        'bg-green-300 dark:bg-green-500': type === 'success',
        'bg-red-300 dark:bg-red-500': type === 'error',
        'bg-orange-300 dark:bg-orange-500': type === 'warning',
        'bg-blue-300 dark:bg-blue-500': type === 'info',
      }"
    ></div>
  </div>
</template>

<style scoped>
.toast {
  animation: show 1s ease-in-out;
}

.time {
  animation: timeOut 5s ease-in-out;
}

@keyframes timeOut {
  0% {
    width: 100%;
  }
  100% {
    width: 0%;
  }
}

@keyframes show {
  0% {
    transform: translateX(100%);
  }
  30% {
    transform: translateX(-2%);
  }
  70% {
    transform: translateX(0%);
  }
  80% {
    transform: translateX(2%);
  }
  100% {
    transform: translateX(0%);
  }
}
</style>
