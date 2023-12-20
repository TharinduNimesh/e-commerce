<script setup>
useHead({
  title: "Register | E-Commerce",
});

const genders = [
  {
    label: "Male",
    value: 1,
  },
  {
    label: "Female",
    value: 2,
  },
];
</script>

<template>
  <div
    class="main-container w-full min-h-screen text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-secondary-dark flex justify-center items-center p-5"
  >
    <div
      class="min-w-[400px] max-w-[1050px] w-2/3 lg:w-full flex border border-blue-200 dark:border-blue-950 bg-primary-light-transparent dark:bg-primary-dark-transparent rounded backdrop-blur-lg shadow-lg dark:shadow-black"
    >
      <div
        class="hidden lg:flex lg:w-5/12 rounded flex-col justify-center py-3"
      >
        <div class="w-full flex justify-center">
          <img
            src="/img/register-vector.png"
            alt="Login Img"
            class="max-w-[340px] mb-8 w-full h-full object-contain"
          />
        </div>
        <div class="w-full flex justify-center">
          <div class="w-full flex flex-col gap-3 px-5">
            <h1 class="text-2xl uppercase font-bold">Join. Click. Thrive.</h1>
            <p class="text-md text-slate-600 dark:text-gray-400">
              Unlock boundless possibilities! Register now to elevate your
              online shopping experience. Seamlessly connect, explore, and
              redefine your world of possibilities with us.
            </p>
          </div>
        </div>
      </div>
      <div class="w-full lg:w-7/12 flex flex-col gap-5 py-5">
        <div class="w-full text-center">
          <h2 class="text-2xl uppercase font-bold">JOIN WITH US TODAY</h2>
        </div>
        <div class="w-full px-10 mt-5 flex flex-col gap-5">
          <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-2">
            <div>
              <PrimaryInput
                label="First Name"
                placeholder="Enter your First Name"
                type="text"
              />
            </div>
            <div>
              <PrimaryInput
                label="Last Name"
                placeholder="Enter your Last Name"
                type="text"
              />
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <div class="col-span-2">
              <PrimaryInput
                label="Mobile"
                placeholder="Enter your mobile number"
                type="text"
              />
            </div>
            <div>
              <PrimarySelect label="Gender" placeholder="Choose" :options="genders" />
            </div>
          </div>
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
            <div class="w-full flex justify-start items-center mt-2">
              <UCheckbox name="remember" label="Remember Me" />
            </div>
          </div>
        </div>
        <div class="w-full flex flex-col items-center px-10 mt-5">
          <PrimaryButton
            text="Sign Up"
            @onclick="setLoading"
            :is-loading="loading"
          />
          <div class="w-full flex justify-center items-center mt-5">
            <PrimaryLink to="/login" text="Already Have An Account ?" />
          </div>
        </div>
        <div class="w-full flex justify-center items-center mt-5">
          <PrimaryLink text="Return Back To Home." />
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
  background-attachment: fixed;
}
</style>
