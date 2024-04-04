type CartItem = {
  id: number;
  name: string;
  price: number;
};

type CartStatus = "already" | "added";

export const useCartStore = defineStore("useCartStore", {
  state: () => ({
    cart: [] as CartItem[],
  }),
  actions: {
    add(item: CartItem): CartStatus {
      // check if item already exists in cart
      const existingItem = this.cart.find((i) => i.id === item.id);
      if (existingItem) {
        return "already";
      }
      this.cart.push(item);
      if (useAuthStore().isLoggedIn) {
        useApiFetch("/api/cart", {
          method: "POST",
          body: { id: item.id },
        });
      }
      localStorage.setItem("cart", JSON.stringify(this.cart));
      return "added";
    },
  },
});
