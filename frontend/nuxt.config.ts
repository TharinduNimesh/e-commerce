// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  css: ["~/assets/css/style.css"],
  modules: ["@nuxt/ui", "nuxt-icon", "@pinia/nuxt"],
  ssr: false,
  pinia: {
    storesDirs: ["./stores/**"],
  },
  imports: {
    dirs: ["stores"]
  },
  runtimeConfig: {
    public: {
      apiURL: process.env.API_URL || "http://localhost:3000",
    }
  }
});
