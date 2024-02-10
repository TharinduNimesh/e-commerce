<script setup>
const color = useColorMode();
const notifications = useNotifications().value;

onMounted(() => {
  window.addEventListener("keyup", (event) => {
    keyHandler(event);
  });
  setInterval(() => {
    removeExpiredNotification();
  }, 500);
});

function keyHandler(event) {
  // update theme on ctrl + enter
  if (event.ctrlKey && event.key === "Enter") {
    changeTheme();
  }
}

function removeExpiredNotification() {
  const container = document.querySelector("#notifications");
  const notificationList = container.querySelectorAll(".toast");
  notificationList.forEach((notification) => {
    if (new Date(notification.dataset.createdAt) < Date.now() - 5000) {
      notification.remove();
    }
  });
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
    <div class="fixed right-5 top-5 z-[99999999]" id="notifications">
      <!-- Notifications (Toasts) Will Appear Here -->
      <Toast
        v-for="notification in notifications"
        :key="notification.message"
        :type="notification.type"
        :title="notification.title"
        :message="notification.message"
      />
    </div>
    <NuxtPage />
  </div>
</template>
