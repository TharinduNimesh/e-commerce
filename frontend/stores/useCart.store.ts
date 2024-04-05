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
        useApiFetch("/api/cart/add", {
          method: "POST",
          body: { id: item },
        });
      }
      localStorage.setItem("cart", JSON.stringify(this.cart));
      return "added";
    },
    remove(items: Array<string>, removeRemote = true) {
      this.cart = this.cart.filter((item) => !items.includes(item));
      if (useAuthStore().isLoggedIn && removeRemote) {
        useApiFetch("/api/cart", {
          method: "DELETE",
          body: { items },
        });
      }
      localStorage.setItem("cart", JSON.stringify(this.cart));
    },
    setCart(cart: string[]) {
      this.cart = cart;
    },
    async sync() {
      if (useAuthStore().isLoggedIn) {
        await useApiFetch("/api/cart/add", {
          method: "POST",
          body: { cart: this.cart },
        });
        const { data } = await useApiFetch("/api/cart", {
          method: "POST",
        });
        if (data) {
          const cart_arr = data.cart.map((item: any)=> item._id);
          this.cart = cart_arr;
          localStorage.setItem("cart", JSON.stringify(this.cart));
        }
      }
    },
  },
});
