<script setup>
const payments = ref(0);
</script>

<template>
  <NuxtLayout name="settings">
    <div
      class="bg-primary-light-transparent dark:bg-primary-dark-transparent p-5 lg:p-8 shadow-lg rounded-lg dark:shadow-black"
    >
      <div class="w-full">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-slate-200">
          Financial & Payments
        </h3>
        <div
          class="p-3 md:p-5 rounded-lg mt-3 border text-green-500 bg-green-50 border-green-500 dark:bg-green-950"
        >
          Trust ComicCage with confidence! Safely manage and store your credit
          card information in our secure system. Your data's security is our top
          priority, and we take responsibility for safeguarding it, ensuring a
          worry-free and protected experience for your comic purchases. Your
          trust means everything to us.
        </div>
      </div>
      <div class="grid grid-cols-2 mt-5">
        <div
          class="col-span-full lg:col-span-1 flex justify-center items-center order-1 lg:order-2"
        >
          <img
            src="/img/the-joker.png"
            alt="Financial & Payments"
            class="max-w-[300px] mx-auto"
          />
        </div>
        <div class="col-span-full lg:col-span-1 order-2 lg:order-1">
          <div class="w-full flex flex-col gap-3">
            <span
              v-if="payments === 0"
              class="mt-5 text-lg text-center italic text-gray-500 dark:text-slate-400"
            >
              No payment methods added yet.
            </span>
            <template v-else>
              <div
                v-for="i in payments"
                :key="i"
                class="w-full text-gray-500 dark:text-gray-400 flex items-center justify-between rounded-lg border bg-gray-100 dark:bg-primary-dark border-gray-300 dark:border-gray-500 px-5 py-3"
              >
                <div class="flex items-center gap-3">
                  <img src="/img/payments/visa.png" alt="Visa" class="h-8" />
                  <span> 4111 1111 1111 1111 </span>
                </div>
                <div>
                  <UButton
                    color="gray"
                    variant="link"
                    icon="solar:pen-new-square-line-duotone"
                  />
                  <UButton
                    color="gray"
                    variant="link"
                    icon="solar:trash-bin-2-outline"
                    @click="payments -= 1"
                  />
                </div>
              </div>
            </template>

            <div class="w-full px-5">
              <UButton
                block
                size="lg"
                variant="solid"
                color="primary"
                icon="ic:round-add"
                @click="payments += 1"
              >
                Add Payment Method
              </UButton>
            </div>
          </div>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
