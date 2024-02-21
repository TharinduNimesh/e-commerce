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

const form = ref({
  first_name: "",
  last_name: "",
  mobile: "",
  gender: "",
  email: "",
  password: "",
});

const loading = ref(false);

async function register() {
  loading.value = true;
  const { data } = await useApiFetch("/api/register", {
    method: "POST",
    body: form.value,
  });
  if (data) {
    useNotifications().value.push({
      type: "success",
      title: "Congratulations 🎉",
      message: "You have successfully registered.",
    });
    form.value = useFormReset(form.value);
    useRouter().push("/login");
  }
  loading.value = false;
}
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
            src="/img/spiderman-reading-2.png"
            alt="Register Img"
            class="max-w-[300px] mb-8 w-full h-full object-contain"
          />
        </div>
        <div class="w-full flex justify-center">
          <div class="w-full flex flex-col gap-3 px-5">
            <h1 class="text-2xl uppercase font-bold">
              Join the League, Unlock Comic Realms!
            </h1>
            <p class="text-md text-slate-600 dark:text-gray-400">
              Embark on a journey with ComicCage. Register now to access an
              exclusive universe of digital comics. Become a member, unlock the
              extraordinary, and start your thrilling collection today.
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
            <UFormGroup label="First Name" required>
              <UInput
                placeholder="Enter your First Name"
                type="text"
                v-model="form.first_name"
              />
            </UFormGroup>
            <UFormGroup label="Last Name" required>
              <UInput
                placeholder="Enter your Last Name"
                type="text"
                v-model="form.last_name"
              />
            </UFormGroup>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <UFormGroup label="Mobile" class="col-span-2" required>
              <UInput
                placeholder="Enter your mobile number"
                type="text"
                v-model="form.mobile"
              />
            </UFormGroup>
            <UFormGroup label="Gender" required>
              <USelectMenu :options="genders" v-model="form.gender" />
            </UFormGroup>
          </div>
          <UFormGroup label="Email Address" required>
            <UInput
              placeholder="Enter your email"
              type="email"
              v-model="form.email"
            />
          </UFormGroup>

          <UFormGroup label="Password" class="flex flex-col" required>
            <UPasswordInput v-model="form.password" />
          </UFormGroup>
        </div>
        <div class="w-full flex flex-col items-center px-10 mt-5">
          <UButton label="Sign Up" @click="register" :loading="loading" block />
          <div class="w-full flex justify-center items-center mt-5">
            <ULink to="/login" class="text-sm text-blue-600 dark:text-blue-500">
              Already Have An Account ?
            </ULink>
          </div>
        </div>
        <div class="w-full flex justify-center items-center mt-5">
          <ULink to="/" class="text-sm text-blue-600 dark:text-blue-500">
            Return Back To Home.
          </ULink>
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
