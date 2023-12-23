export default defineNuxtRouteMiddleware((to, from) => {
  const token = useCookie("XSRF-TOKEN");
  if (token.value) {
    console.log("Already have token, skipping fetch");
    return;
  }
  console.log("Fetching token");
  useApiFetch("/sanctum/csrf-cookie");
});
