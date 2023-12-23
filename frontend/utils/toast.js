const notifications = document.querySelector('#notifications');

export function showNotification() {
  const toast = Vue.component('toast', Toast).$mount();
  notifications.appendChild(toast.$el);
}