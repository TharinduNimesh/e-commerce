export default defineNuxtRouteMiddleware((to, from) => {
  const token = useCookie("XSRF-TOKEN");
  if (!token.value) {
    useApiFetch("/sanctum/csrf-cookie");
  }
});
