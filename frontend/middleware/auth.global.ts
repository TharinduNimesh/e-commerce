export default defineNuxtRouteMiddleware(async (to, from) => {
  // user has already logged in
  if (useAuthStore().isLoggedIn) return;

  //   user has not logged in, fetch user to check if user has logged in
  await useAuthStore().fetchUser();
  if (useAuthStore().isLoggedIn) return;

  /* 
    if user has not logged in, redirect to login page
    but user has access to shop, and /login /register pages
  */
  if (!to.path.includes("/app")) return;

  return navigateTo("/login");
});
