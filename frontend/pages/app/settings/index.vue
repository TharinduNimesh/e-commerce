<script setup>
// const user = await useAuth();
const editable = ref(false);
const display_form = ref({
  first_name: "Tharindu",
  last_name: "Nimesh",
  gender: "Male",
  email: "tharindunimesh.abc@gmail.com",
  mobile: "+94771234567",
});

const items = [
  {
    label: "Your Account",
    icon: "material-symbols:person-outline-rounded",
    path: "/app/settings",
  },
  {
    label: "Financials & Payments",
    icon: "material-symbols:credit-card-outline",
    path: "/app/settings/payments",
  },
  {
    label: "Preferences",
    icon: "material-symbols:brush-outline-sharp",
    path: "/app/settings/preferences",
  },
  {
    label: "Change Password",
    icon: "material-symbols:key-outline-rounded",
    path: "/app/settings/change-password",
  },
  {
    label: "Logout",
    icon: "material-symbols:power-settings-new-rounded",
    path: "/app/settings/logout",
  },
];
</script>

<template>
  <NuxtLayout name="shop">
    <div class="flex justify-center pt-20">
      <div
        class="container flex flex-col md:flex-row items-center md:items-start pt-10 gap-4 px-5 sm:px-0"
      >
        <div
          class="w-full md:max-w-[300px] py-5 flex flex-col gap-1 bg-primary-light-transparent dark:bg-primary-dark-transparent shadow-lg rounded-lg dark:shadow-black"
        >
          <NuxtLink
            v-for="item in items"
            :key="item"
            :to="item.path"
            class="relative w-full h-10 flex items-center px-5"
            :class="{
              'text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-300':
                $route.path !== item.path,
              'text-violet-600 dark:text-violet-500': $route.path === item.path,
            }"
          >
            <div
              v-if="$route.path === item.path"
              class="absolute w-1 h-full rounded-l bg-violet-600 dark:accent-violet-600"
            ></div>
            <Icon :name="item.icon" class="text-lg mx-3" />
            <span class="text-sm uppercase font-bold">{{ item.label }}</span>
          </NuxtLink>
        </div>
        <div class="flex-1 flex flex-col gap-8">
          <div
            class="bg-primary-light-transparent dark:bg-primary-dark-transparent p-5 lg:p-8 shadow-lg rounded-lg dark:shadow-black"
          >
            <div class="w-full">
              <h3
                class="text-xl font-semibold text-gray-700 dark:text-slate-200"
              >
                Account
              </h3>
              <p class="text-gray-500 dark:text-slate-400">
                Real-time information about your account and access to your
                settings.
              </p>
            </div>
            <UDivider class="my-5" />
            <div
              class="flex flex-col lg:flex-row gap-3 lg:gap-3 justify-between"
            >
              <div class="flex gap-5">
                <UAvatar
                  size="3xl"
                  src="https://avatars.githubusercontent.com/u/739984?v=4"
                  alt="Avatar"
                />
                <div class="flex flex-col justify-center">
                  <h3
                    class="text-lg font-semibold text-gray-700 dark:text-slate-200"
                  >
                    Profile Picture
                  </h3>
                  <p class="text-gray-500 dark:text-slate-400">
                    png, jpg, jpeg & webp up to 10MB
                  </p>
                </div>
              </div>
              <div class="flex gap-3 items-center">
                <UButton
                  size="sm"
                  variant="solid"
                  color="primary"
                  icon="ic:outline-file-upload"
                >
                  Upload New Picture
                </UButton>
                <UButton variant="soft" color="red" icon="radix-icons:reset">
                  Reset
                </UButton>
              </div>
            </div>
            <div class="flex flex-col mt-5">
              <h3
                class="text-lg font-semibold text-gray-700 dark:text-slate-200"
              >
                Personal Information
              </h3>
              <div class="grid grid-cols-12 gap-3 mt-3">
                <div class="col-span-full lg:col-span-5">
                  <UFormGroup label="First Name">
                    <UInput
                      color="gray"
                      v-model="display_form.first_name"
                      placeholder="Enter Your First Name"
                      :disabled="!editable"
                    />
                  </UFormGroup>
                </div>
                <div class="col-span-full lg:col-span-5">
                  <UFormGroup label="Last Name">
                    <UInput
                      color="gray"
                      v-model="display_form.last_name"
                      placeholder="Enter Your First Name"
                      :disabled="!editable"
                    />
                  </UFormGroup>
                </div>
                <div class="col-span-full lg:col-span-2">
                  <UFormGroup label="Gender">
                    <UInput
                      color="gray"
                      v-if="!editable"
                      v-model="display_form.gender"
                      placeholder="Enter Your Gender"
                      :disabled="!editable"
                    />
                    <USelect
                      v-else
                      color="gray"
                      v-model="display_form.gender"
                      :options="['Male', 'Female']"
                    />
                  </UFormGroup>
                </div>
              </div>
              <h3
                class="text-lg font-semibold text-gray-700 dark:text-slate-200 mt-5"
              >
                Contact Information
              </h3>
              <div class="flex flex-col gap-3 mt-3">
                <div>
                  <UFormGroup label="Email">
                    <div class="grid grid-cols-12 gap-3">
                      <div class="col-span-full lg:col-span-8">
                        <UInput
                          color="gray"
                          v-model="display_form.email"
                          placeholder="Enter Your Email"
                          disabled
                        />
                      </div>
                      <div class="col-span-full lg:col-span-4">
                        <UButton
                          block
                          size="lg"
                          variant="solid"
                          color="black"
                          icon="ic:outline-tips-and-updates"
                        >
                          Update Email Address
                        </UButton>
                      </div>
                    </div>
                  </UFormGroup>
                </div>
                <div>
                  <UFormGroup label="Phone Number">
                    <UInput
                      color="gray"
                      v-model="display_form.mobile"
                      placeholder="Enter Your Phone Number"
                      :disabled="!editable"
                    />
                  </UFormGroup>
                </div>
                <div class="flex justify-center lg:justify-end gap-3">
                  <UButton
                    v-if="!editable"
                    size="lg"
                    variant="solid"
                    color="primary"
                    icon="solar:pen-new-square-line-duotone"
                    @click="editable = !editable"
                  >
                    Enable Editing
                  </UButton>
                  <template v-else>
                    <UButton
                      size="lg"
                      variant="solid"
                      color="primary"
                      icon="solar:check-circle-outline"
                      class="order-1 lg:order-2"
                      @click="editable = !editable"
                    >
                      Save Changes
                    </UButton>
                    <UButton
                      size="lg"
                      variant="solid"
                      color="red"
                      icon="solar:close-circle-outline"
                      class="order-2 lg:order-1"
                      @click="editable = !editable"
                    >
                      Cancel
                    </UButton>
                  </template>
                </div>
              </div>
            </div>
          </div>
          <div
            class="bg-primary-light-transparent dark:bg-primary-dark-transparent p-5 lg:p-8 shadow-lg rounded-lg dark:shadow-black"
          >
            <h2 class="text-xl font-semibold text-red-500 dark:text-red-700">
              <Icon name="solar:danger-circle-outline" /> Account Deactivation
            </h2>
            <p class="text-gray-500 dark:text-slate-400 mt-2">
              Deactivating your account will disable your profile and remove
              your name and photo from most things you've shared on
              <span class="font-semibold">ComicCage</span>. Some information may
              still be visible to others.
            </p>
            <div class="flex justify-center lg:justify-end mt-4">
              <UButton
                size="lg"
                variant="solid"
                color="red"
                icon="solar:trash-bin-2-outline"
              >
                Deactivate Account
              </UButton>
            </div>
          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>

<!-- <style scoped>
.active {
  @apply;
}
</style> -->
