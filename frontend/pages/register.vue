<script setup>
useHead({
  title: "Register | E-Commerce",
});
</script>

<template>
  <div
    class="main-container w-full min-h-screen text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-secondary-dark flex justify-center items-center p-5"
  >
    <div
      class="min-w-[400px] max-w-[850px] w-2/3 flex border border-blue-200 dark:border-blue-950 bg-primary-light-transparent dark:bg-primary-dark-transparent rounded backdrop-blur-lg shadow-lg dark:shadow-black"
    >
      <div class="w-full lg:w-1/2 flex flex-col gap-5 py-5">
        <div class="w-full text-center">
          <h2 class="text-2xl uppercase font-bold">GET STARTED</h2>
        </div>
        <div class="w-full px-10 mt-5 flex flex-col gap-7">
          <PrimaryInput
            label="Email"
            placeholder="Enter your email"
            type="email"
          />
          <div class="flex flex-col">
            <PrimaryInput
              label="Password"
              placeholder="••••••••••••"
              type="password"
            />
            <div class="w-full flex justify-end items-center mt-2">
              <PrimaryLink text="Forgot Password ?" />
            </div>
          </div>
        </div>
        <div class="w-full flex flex-col items-center px-10 mt-5">
          <button
            class="bg-blue-500 dark:bg-blue-800 w-full py-2 rounded text-gray-100 dark:text-gray-300 font-bold uppercase shadow-md dark:shadow-black"
            @click="setTheme"
          >
            Sign In
          </button>
          <div class="w-full flex justify-center items-center mt-5">
            <PrimaryLink text="Don't have an account ?" />
          </div>
        </div>
        <div class="w-full flex justify-center items-center mt-10">
          <PrimaryLink text="Return Back To Home." />
        </div>
      </div>
      <div class="hidden lg:flex lg:w-1/2 rounded flex-col justify-center py-3">
        <div class="w-full flex justify-center">
          <img
            src="/img/login-vector.png"
            alt="Login Img"
            class="max-w-[240px] w-full h-full object-contain"
          />
        </div>
        <div class="w-full flex justify-center">
          <div class="w-full flex flex-col items-center gap-3 px-5">
            <h1 class="text-2xl uppercase font-bold text-center">
              Shop Dreams, Click Reality.
            </h1>
            <p class="text-md text-center text-slate-600 dark:text-gray-400">
              Embark on a digital shopping journey where desires meet
              convenience. Explore curated collections and redefine your style
              effortlessly. Welcome to seamless online indulgence.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.main-container {
  background-image: url("/img/login-bg.png");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
</style>
