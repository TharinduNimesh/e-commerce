type CartStatus = "already" | "added";

export const useCartStore = defineStore("useCartStore", {
  state: () => ({
    cart: [] as string[],
  }),
  actions: {
    add(item: string): CartStatus {
      // check if item already exists in cart
      const existingItem = this.cart.includes(item);
      if (existingItem) {
        return "already";
      }
      this.cart.push(item);
      if (useAuthStore().isLoggedIn) {
        useApiFetch("/api/cart", {
          method: "POST",
          body: { id: item },
        });
      }
      localStorage.setItem("cart", JSON.stringify(this.cart));
      return "added";
    },
    remove(id: string) {
      this.cart = this.cart.filter((item) => item !== id);
      if (useAuthStore().isLoggedIn) {
        useApiFetch("/api/cart", {
          method: "DELETE",
          body: { id },
        });
      }
      localStorage.setItem("cart", JSON.stringify(this.cart));
    },
    setCart(cart: string[]) {
      this.cart = cart;
    },
  },
});
