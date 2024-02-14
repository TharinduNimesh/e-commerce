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
    useNotifications().value.push({
      message: "Login successful",
    });

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
          <UFormGroup label="Email Address">
            <UInput
              placeholder="Enter your email"
              type="email"
              v-model="form.email"
            />
          </UFormGroup>

          <UFormGroup label="Email Address">
            <template #hint>
              <ULink
                @click="forget_password_opened = true"
                class="text-sm text-blue-600 dark:text-blue-500"
              >
                Forgot Password ?
              </ULink>
            </template>

            <template #help>
              <UCheckbox v-model="form.remember_me" label="Remember Me" />
            </template>
            <UInput
              label="Password"
              placeholder="••••••••••••"
              type="password"
              v-model="form.password"
            />
          </UFormGroup>
        </div>
        <div class="w-full flex flex-col items-center px-10 mt-5">
          <UButton label="Sign In" @click="login" :loading="loading" block />
          <div class="w-full flex justify-center items-center mt-5">
            <ULink
              to="/register"
              class="text-sm text-blue-600 dark:text-blue-500"
            >
              Don't have an account ?
            </ULink>
          </div>
        </div>
        <div class="w-full flex justify-center items-center mt-10">
          <ULink to="/" class="text-sm text-blue-600 dark:text-blue-500">
            Return Back To Home.
          </ULink>
        </div>
      </div>
      <div class="hidden lg:flex lg:w-1/2 rounded flex-col justify-center py-3">
        <div class="w-full flex justify-center">
          <img
            src="/img/spiderman-reading-1.png"
            alt="Login Img"
            class="max-w-[240px] w-full h-full object-contain"
          />
        </div>
        <div class="w-full flex justify-center">
          <div class="w-full flex flex-col items-center gap-3 px-5">
            <h1 class="text-2xl uppercase font-bold text-center">
              Enter Your Portal to Comic Bliss!
            </h1>
            <p class="text-md text-center text-slate-600 dark:text-gray-400">
              Welcome back, hero! Your next adventure awaits. Log in to
              ComicCage and resume your exploration of thrilling narratives,
              stunning visuals, and a world of endless imagination.
            </p>
          </div>
        </div>
      </div>
    </div>
    <!-- Forget password modal -->
    <FormForgetPassword
      v-model="forget_password_opened"
      @onclose="forget_password_opened = false"
    />
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
