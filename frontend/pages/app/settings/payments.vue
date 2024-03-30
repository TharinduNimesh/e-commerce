<script setup>
const payments = ref([]);
const is_payment_model_open = ref(false);
const is_edit_payment_model_open = ref(false);
const is_loading = ref(false);
onMounted(() => {
  loadPayments();
});

const payment_method_form = ref({
  payment_type: null,
  card_number: "",
  expiry_date: "",
  cvv: "",
});

function setPaymentType(type) {
  payment_method_form.value.payment_type = type;
}

async function addPaymentMethod() {
  is_loading.value = true;
  const { data } = await useApiFetch("/api/payments/add", {
    method: "POST",
    body: payment_method_form.value,
  });
  if (data) {
    useNotifications().value.push({
      status: "success",
      message: "New Payment Method has been added",
    });
  }
  is_loading.value = false;
}

async function loadPayments() {
  const { data } = await useApiFetch("/api/payments");
  if (data) {
    payments.value = data.payment_methods;
  }
}

function deletePaymentMethod(id) {
  payments.value = payments.value.filter((payment) => payment.id !== id);
  useNotifications().value.push({
    status: "success",
    message: "Payment Method has been deleted",
  });

  useApiFetch(`/api/payments/delete/${id}`, {
    method: "DELETE",
  });
}
</script>

<template>
  <div>
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
            card information in our secure system. Your data's security is our
            top priority, and we take responsibility for safeguarding it,
            ensuring a worry-free and protected experience for your comic
            purchases. Your trust means everything to us.
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
                  v-for="(payment, index) in payments"
                  :key="payment.id"
                  class="w-full text-gray-500 dark:text-gray-400 flex items-center justify-between rounded-lg border bg-gray-100 dark:bg-primary-dark border-gray-300 dark:border-gray-500 px-5 py-3"
                >
                  <div class="flex items-center gap-3">
                    <img
                      :src="`/img/payments/${payment.payment_type}.png`"
                      alt="Visa"
                      class="h-8"
                    />
                    <span> {{ payment.card_number }} </span>
                  </div>
                  <div>
                    <UButton
                      color="gray"
                      variant="link"
                      icon="solar:pen-new-square-line-duotone"
                      @click="is_edit_payment_model_open = true"
                    />
                    <UButton
                      color="gray"
                      variant="link"
                      icon="solar:trash-bin-2-outline"
                      @click="deletePaymentMethod(payment.id)"
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
                  @click="is_payment_model_open = true"
                >
                  Add Payment Method
                </UButton>
              </div>
            </div>
          </div>
        </div>

        <!-- Add Payment Modal End -->
        <UModal v-model="is_payment_model_open">
          <div
            class="p-5 bg-[url('/img/modal-bg.png')] bg-cover bg-right bg-no-repeat"
          >
            <div>
              <div>
                <h3
                  class="text-xl font-semibold text-gray-700 dark:text-slate-200"
                >
                  Add Payment Method
                </h3>
              </div>
            </div>

            <div class="grid grid-cols-3 gap-4 py-5">
              <div class="col-span-3 flex justify-between px-5 flex-wrap">
                <div
                  class="flex flex-col items-center gap-2"
                  @click="setPaymentType('Visa')"
                >
                  <img src="/img/payments/Visa.png" alt="Visa" class="h-8" />
                  <URadio
                    v-model="payment_method_form.payment_type"
                    value="Visa"
                  />
                </div>
                <div
                  class="flex flex-col items-center gap-2"
                  @click="setPaymentType('Mastercard')"
                >
                  <img
                    src="/img/payments/Mastercard.png"
                    alt="Mastercard"
                    class="h-8"
                  />
                  <URadio
                    v-model="payment_method_form.payment_type"
                    value="Mastercard"
                  />
                </div>
                <div
                  class="flex flex-col items-center gap-2"
                  @click="setPaymentType('Amex')"
                >
                  <img src="/img/payments/Amex.png" alt="Amex" class="h-8" />
                  <URadio
                    v-model="payment_method_form.payment_type"
                    value="Amex"
                  />
                </div>
              </div>
              <div class="col-span-3">
                <UInput
                  label="Card Number"
                  placeholder="Enter your card number"
                  v-model="payment_method_form.card_number"
                />
              </div>
              <div class="col-span-2">
                <UInput
                  label="Expiry Date"
                  placeholder="MM/YY"
                  v-model="payment_method_form.expiry_date"
                />
              </div>
              <div class="col-span-1">
                <UInput
                  label="CVV"
                  placeholder="Enter CVV"
                  v-model="payment_method_form.cvv"
                />
              </div>
            </div>

            <div>
              <div class="flex justify-end gap-3">
                <UButton
                  @click="is_payment_model_open = false"
                  color="gray"
                  label="Close"
                />
                <UButton
                  label="Submit"
                  :loading="is_loading"
                  @click="addPaymentMethod"
                />
              </div>
            </div>
          </div>
        </UModal>
        <!-- Add Payment Modal End -->

        <!-- Edit Payment Modal Start -->
        <UModal v-model="is_edit_payment_model_open">
          <div
            class="p-5 bg-[url('/img/modal-bg.png')] bg-cover bg-right bg-no-repeat"
          >
            <div>
              <div>
                <h3
                  class="text-xl font-semibold text-gray-700 dark:text-slate-200"
                >
                  Add Payment Method
                </h3>
              </div>
            </div>

            <div class="grid grid-cols-3 gap-4 py-5">
              <div class="col-span-3 flex justify-between flex-wrap">
                <UInput placeholder="Search..." class="w-full" block disabled>
                  <template #leading>
                    <img class="w-[30px]" src="/img/payments/Visa.png" />
                  </template>
                </UInput>
              </div>
              <div class="col-span-3">
                <UInput
                  label="Card Number"
                  placeholder="Enter your card number"
                  v-model="payment_method_form.card_number"
                />
              </div>
              <div class="col-span-2">
                <UInput
                  label="Expiry Date"
                  placeholder="MM/YY"
                  v-model="payment_method_form.expiry_date"
                />
              </div>
              <div class="col-span-1">
                <UInput
                  label="CVV"
                  placeholder="Enter CVV"
                  v-model="payment_method_form.cvv"
                />
              </div>
            </div>

            <div>
              <div class="flex justify-end gap-3">
                <UButton
                  @click="is_edit_payment_model_open = false"
                  color="gray"
                  label="Close"
                />
                <UButton
                  label="Submit"
                  :loading="is_loading"
                  @click="addPaymentMethod"
                />
              </div>
            </div>
          </div>
        </UModal>
        <!-- Edit Payment Modal End -->
      </div>
    </NuxtLayout>
  </div>
</template>
