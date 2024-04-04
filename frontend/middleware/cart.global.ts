export default defineNuxtRouteMiddleware(async (to, from) => {
  // fetch cart data from localStorage
  const cart = localStorage.getItem("cart");

  // if cart data exists, set it to the store
  if (cart) {
    useCartStore().setCart(JSON.parse(cart));
  }

  // if user is logged in, sync cart data
  if (useAuthStore().isLoggedIn) {
    console.log("syncing cart data");
    useCartStore().sync();
  }
  return;
});
