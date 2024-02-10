<script setup>
const props = defineProps(["modalValue"]);
const isOpen = computed(() => props.modalValue);
const emit = defineEmits(["onclose"]);

const is_loading = ref(false);
const step = ref(1);
let prev_email;

// forms
const email = ref("");
const otp = ref("");
const attempts = ref(5);
const new_password = ref({
  password: "",
  password_confirmation: "",
});

async function sendOtp() {
  // if loading, return
  if (is_loading.value) {
    useNotifications().value.push({
      message: "A request is already in progress",
      title: "Please wait",
      type: "warning",
    });
    return;
  }
  // send request to server
  is_loading.value = true;
  const { data } = await useApiFetch("/api/forgot-password", {
    method: "POST",
    body: {
      email: email.value || prev_email,
    },
  });
  if (data) {
    useNotifications().value.push({
      message: data.message,
      title: "Check your Inbox",
    });
    // set details for next step
    prev_email = email.value;
    attempts.value = data.pending_requests;
    step.value = 2;
  }
  is_loading.value = false;
}

async function verify() {
  // if loading, return
  if (is_loading.value) {
    useNotifications().value.push({
      message: "A request is already in progress",
      title: "Please wait",
      type: "warning",
    });
    return;
  }
  // send request to server
  is_loading.value = true;
  const { data } = await useApiFetch("/api/verify", {
    method: "POST",
    body: {
      email: prev_email,
      otp: otp.value,
    },
  });
  if (data) {
    useNotifications().value.push({
      message: data.message,
      title: "Congratulations 🎉",
    });
    // set details for next step
    step.value = 3;
  }
  is_loading.value = false;
}

async function updatePassword() {
  // if loading, return
  if (is_loading.value) {
    useNotifications().value.push({
      message: "A request is already in progress",
      title: "Please wait",
      type: "warning",
    });
    return;
  }

  // check if password and confirm password matches
  if (
    new_password.value.password !== new_password.value.password_confirmation
  ) {
    useNotifications().value.push({
      message: "Password and confirm password does not match",
      title: "Try Again",
      type: "warning",
    });
    return;
  }

  is_loading.value = true;
  // send request to server
  const { data } = await useApiFetch("/api/update-password", {
    method: "PUT",
    body: {
      email: prev_email,
      otp: otp.value,
      password: new_password.value.password,
      password_confirmation: new_password.value.password_confirmation,
    },
  });

  if (data) {
    useNotifications().value.push({
      message: data.message,
      title: "Congratulations 🎉",
    });

    // reset form
    email.value = "";
    otp.value = "";
    attempts.value = 5;
    new_password.value.password = "";
    new_password.value.password_confirmation = "";

    // close modal
    step.value = 1;
    emit("onclose");
  }
  is_loading.value = false;
}
</script>

<template>
  <UModal v-model="isOpen">
    <div
      class="p-5 bg-[url('/img/modal-bg.png')] bg-cover bg-right bg-no-repeat"
    >
      <div v-show="step === 1">
        <h1
          class="text-xl uppercase font-bold text-gray-700 dark:text-gray-300"
        >
          Forgot Your Password
        </h1>
        <UDivider class="my-3" />
        <p class="text-gray-500 dark:text-gray-400">
          Enter your email address below and we'll send you a OTP code to reset
          your password.
        </p>
        <div class="mt-4">
          <PrimaryInput
            placeholder="Enter your email"
            type="email"
            v-model="email"
          />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 mt-5 gap-2">
          <div class="order-2 md:order-1">
            <PrimaryButton
              @onclick="$emit('onclose')"
              text="Close"
              class="bg-red-500 hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-800"
            />
          </div>
          <div class="order-1 md:order-2">
            <PrimaryButton
              :is-loading="is_loading"
              text="Continue"
              @onclick="sendOtp"
            />
          </div>
        </div>
      </div>
      <div v-show="step === 2">
        <div class="flex justify-between">
          <h1
            class="text-xl uppercase font-bold text-gray-700 dark:text-gray-300"
          >
            Check your Inbox
          </h1>
          <div
            class="h-full flex items-center px-2 text-2xl"
            v-show="is_loading"
          >
            <Icon
              name="material-symbols-light:sync-outline"
              class="rotate-180 animate-spin"
            />
          </div>
        </div>
        <UDivider class="my-3" />
        <p class="text-gray-500 dark:text-gray-400">
          We have sent you a OTP code to reset your password. Please check your
          inbox and enter the code below.
        </p>
        <div class="mt-4 flex justify-center gap-2">
          <PrimaryInput
            placeholder="xxxxxx"
            styles="text-center uppercase"
            v-model="otp"
          />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 mt-5 gap-2">
          <div class="order-2 md:order-1">
            <PrimaryButton
              @onclick="step--"
              text="Back"
              class="bg-red-500 hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-800"
            />
          </div>
          <div class="order-1 md:order-2">
            <PrimaryButton text="Submit" @onclick="verify" />
          </div>
        </div>
        <div class="flex flex-col items-center text-center mt-5 gap-y-2">
          <p class="text-sm text-gray-600 dark:text-gray-300">
            Didn't receive the code?
            <span
              class="text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-500 cursor-pointer"
              @click="sendOtp"
            >
              Resend
            </span>
          </p>
          <span class="text-sm text-gray-500 dark:text-gray-400">
            You have only
            <span class="text-red-500">{{ attempts }}</span> attempts left.
          </span>
        </div>
      </div>
      <div v-show="step === 3">
        <h1
          class="text-xl uppercase font-bold text-gray-700 dark:text-gray-300"
        >
          Reset your Password
        </h1>
        <UDivider class="my-3" />
        <p class="text-gray-500 dark:text-gray-400">
          Enter your new password below.
        </p>
        <div class="mt-4">
          <PrimaryInput
            label="New Password"
            placeholder="Enter your new password"
            type="password"
            v-model="new_password.password"
          />
        </div>
        <div class="mt-4">
          <PrimaryInput
            label="Confirm Password"
            placeholder="Confirm your new password"
            type="password"
            v-model="new_password.password_confirmation"
          />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 mt-5 gap-2">
          <div class="order-2 md:order-1">
            <PrimaryButton
              @onclick="$emit('onclose')"
              text="Close"
              class="bg-red-500 hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-800"
            />
          </div>
          <div class="order-1 md:order-2">
            <PrimaryButton
              :is-loading="is_loading"
              text="Confirm"
              @onclick="updatePassword"
            />
          </div>
        </div>
        <div class="flex justify-center text-center mt-5">
          <p
            class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400"
          >
            Password validation rules
            <span>
              <UPopover
                mode="hover"
                :popper="{ arrow: true }"
                class="flex items-center m-0 p-0"
              >
                <Icon
                  name="material-symbols-light:help-outline"
                  class="text-md text-gray-700 dark:text-gray-300"
                />

                <template #panel>
                  <div class="p-4 min-w-[200px] max-w-[300px]">
                    Password should have minimum eight characters, at least one
                    uppercase letter, one lowercase letter, one number and one
                    special character
                  </div>
                </template>
              </UPopover>
            </span>
          </p>
        </div>
      </div>
    </div>
  </UModal>
</template>
