<script setup>
useHead({
  title: "Login | E-Commerce",
});

const credentials = useCookie("credentials");
const loading = ref(false);
const forget_password_opened = ref(false);

const form = ref({
  email: "",
  password: "",
  remember_me: false,
});

onMounted(() => {
  // if credentials cookie exists
  if (credentials.value) {
    form.value.email = credentials.value.email;
    form.value.password = Crypto.decrypt(credentials.value.password);
    form.value.remember_me = true;
  }
});

async function login() {
  loading.value = true;
  // Check if form is valid
  const { data } = await useApiFetch("/api/login", {
    method: "POST",
    body: form.value,
  });
  if (data) {
    // if valid show notification
    useNotifications().value.notifications.push({
      message: "Login successful",
    });

    // set user and token
    useAuth().value = data.user;
    localStorage.setItem("auth-token", `Bearer ${data.token}`);

    // if remember me is checked
    if (form.value.remember_me) {
      const password = Crypto.encrypt(form.value.password);
      credentials.value = {
        email: form.value.email,
        password,
      };
    }
    // reset form
    form.value = useFormReset(form.value);
  }
  loading.value = false;
}
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
          <h2 class="text-2xl uppercase font-bold">WELCOME BACK</h2>
        </div>
        <div class="w-full px-10 mt-5 flex flex-col gap-7">
          <PrimaryInput
            label="Email"
            placeholder="Enter your email"
            type="email"
            v-model="form.email"
          />
          <div class="flex flex-col">
            <PrimaryInput
              label="Password"
              placeholder="••••••••••••"
              type="password"
              v-model="form.password"
            />
            <div class="w-full flex justify-between items-center mt-2">
              <UCheckbox v-model="form.remember_me" label="Remember Me" />
              <PrimaryLink
                @onclick="forget_password_opened = true"
                text="Forgot Password ?"
              />
            </div>
          </div>
        </div>
        <div class="w-full flex flex-col items-center px-10 mt-5">
          <PrimaryButton
            text="Sign In"
            @onclick="login"
            :is-loading="loading"
          />
          <div class="w-full flex justify-center items-center mt-5">
            <PrimaryLink to="/register" text="Don't have an account ?" />
          </div>
        </div>
        <div class="w-full flex justify-center items-center mt-10">
          <PrimaryLink to="/" text="Return Back To Home." />
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
    <!-- Forget password modal start -->
    <UModal v-model="forget_password_opened">
      <div class="p-5">
        <h1 class="text-xl uppercase font-bold text-gray-700 dark:text-gray-300">
          Forgot Your Password
        </h1>
        <UDivider class="my-3" />
        <p class="text-gray-500 dark:text-gray-400">
          Enter your email address below and we'll send you a link to reset your
          password.
        </p>
        <div class="mt-4">
          <PrimaryInput placeholder="Enter your email" type="email" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 mt-5 gap-2">
          <div class="order-2 md:order-1">
            <PrimaryButton
              @onclick="forget_password_opened = false"
              text="Close"
              class="bg-red-500 hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-800"
            />
          </div>
          <div class="order-1 md:order-2">
            <PrimaryButton text="Send" />
          </div>
        </div>
      </div>
    </UModal>
    <!-- Forget password modal end -->
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