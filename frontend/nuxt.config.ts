// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  css: ["~/assets/css/style.css"],
  modules: ["@nuxt/ui", "nuxt-icon"],
  ssr: false,
});
