import { defineStore } from "pinia";

type User = {
  id: number;
  first_name: string;
  last_name: string;
  mobile: string;
  email: string;
  gender: string;
  created_at: string;
  updated_at: string;
} | null;

export const useAuthStore = defineStore("useAuthStore", {
  state: () => ({
    user: null as User,
  }),
  getters: {
    isLoggedIn: (state) => state.user != null,
  },
  actions: {
    async fetchUser() {
      const { data } = await useApiFetch("/api/user", {}, false);
      if (data) {
        this.user = data.user;
      } else {
        this.user = null;
      }
    },
    setToken(token: string) {
      localStorage.setItem("auth-token", token);
    },
    logout() {
      this.user = null;
      useApiFetch("/api/logout", {
        method: "POST",
      }, false);
      localStorage.removeItem("auth-token");
      useRouter().push("/login");
    }
  },
});
