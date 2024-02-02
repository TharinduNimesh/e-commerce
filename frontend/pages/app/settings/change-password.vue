<script setup>
const form = ref({
  current_password: "",
  new_password: "",
  confirm_new_password: "",
});
</script>

<template>
  <NuxtLayout name="settings">
    <div
      class="bg-primary-light-transparent dark:bg-primary-dark-transparent p-5 lg:p-8 shadow-lg rounded-lg dark:shadow-black"
    >
      <div class="block lg:hidden mb-5 w-full">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-slate-200">
          Change Password
        </h3>
        <p class="text-gray-500 dark:text-slate-400">
          Update your security with ease! Choose a new password for your
          ComicCage account and keep your comic collection safe and sound.
        </p>
      </div>
      <div class="grid grid-cols-2">
        <div
          class="col-span-full lg:col-span-1 order-1 lg:order-2 flex justify-center items-center"
        >
          <img src="/img/the-shazam.png" alt="Avatar" class="max-w-[300px]" />
        </div>
        <div class="col-span-full lg:col-span-1 order-2 lg:order-1">
          <div class="flex flex-col gap-5">
            <div class="hidden lg:block w-full">
              <h3
                class="text-xl font-semibold text-gray-700 dark:text-slate-200"
              >
                Change Password
              </h3>
              <p class="text-gray-500 dark:text-slate-400">
                Update your security with ease! Choose a new password for your
                ComicCage account and keep your comic collection safe and sound.
              </p>
            </div>
            <UFormGroup label="Current Password">
              <template #label>
                <div class="flex items-center gap-2">
                  <span>Current Password</span>
                  <UPopover
                    mode="hover"
                    :popper="{ arrow: true, placement: 'right' }"
                    class="flex items-center"
                  >
                    <UIcon name="ic:round-info" class="text-gray-500" />

                    <template #panel>
                      <div class="max-w-[200px] p-3">
                        If you don't remember your current password, please
                        logout and use <strong>forget password</strong> option.
                      </div>
                    </template>
                  </UPopover>
                </div>
              </template>
              <UInput
                color="gray"
                v-model="form.current_password"
                placeholder="Enter Your Old Password"
                type="password"
              />
            </UFormGroup>
            <UFormGroup label="New Password">
              <UInput
                color="gray"
                v-model="form.new_password"
                placeholder="Enter Your New Password"
                type="password"
              />
            </UFormGroup>
            <UFormGroup label="Confirm New Password">
              <UInput
                color="gray"
                v-model="form.confirm_new_password"
                placeholder="Confirm Your New Password"
                type="password"
              />
            </UFormGroup>
            <div class="flex justify-center lg:justify-end gap-3">
              <UButton
                size="lg"
                variant="solid"
                color="primary"
                icon="solar:pen-new-square-line-duotone"
              >
                Update Password
              </UButton>
            </div>
          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
