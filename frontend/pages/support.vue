<script setup>
useHead({
  title: "Support | ComicCage",
});

const form = ref({
  first_name: "",
  last_name: "",
  email: "",
  subject: "",
  message: "",
});

async function send() {
  const { data } = await useApiFetch("/api/support/send-message", {
    method: "POST",
    body: form.value,
  });
  if (data) {
    useNotifications().value.push({
      type: "success",
      message: "Message sent successfully",
    });
    form.value = useFormReset(form.value);
  }
}
</script>

<template>
  <div>
    <NuxtLayout name="shop">
      <!-- Hero section start -->
      <section
        class="relative w-full h-[80vh] bg-cover bg-top bg-[url(/img/ninja-turtles.jpg)]"
      >
        <div
          class="absolute w-full h-full bg-black opacity-50 dark:opacity-80"
        ></div>
      </section>
      <!-- Hero section end -->

      <!-- Contact section start -->
      <section class="w-full p-5 lg:p-10">
        <div
          class="w-full flex flex-col md:flex-row bg-primary-light dark:bg-primary-dark shadow-lg dark:shadow-black rounded-lg"
        >
          <div class="w-full md:w-1/2">
            <img
              src="/img/batman-vs-ninja-turtles.png"
              alt="Contact Us"
              class="w-full h-full object-cover rounded-t-lg md:rounded-l-lg"
            />
          </div>
          <div class="w-full md:w-1/2 flex flex-col p-10">
            <h2
              class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100"
            >
              Contact Us
            </h2>
            <p class="text-center text-gray-600 dark:text-gray-400">
              Got questions or suggestions? Reach out through our Contact Us
              form. We value your input! Whether it's inquiries or feedback,
              ComicCage is here to listen and respond promptly. Connect with us
              now!
            </p>
            <form class="flex flex-col gap-5 mt-5">
              <div class="w-full grid grid-cols-2 gap-3">
                <div
                  class="col-span-full sm:col-span-1 md:col-span-full lg:col-span-1"
                >
                  <UFormGroup label="First Name" required>
                    <UInput
                      type="text"
                      placeholder="Enter Your First Name"
                      v-model="form.first_name"
                    />
                  </UFormGroup>
                </div>
                <div
                  class="col-span-full sm:col-span-1 md:col-span-full lg:col-span-1"
                >
                  <UFormGroup label="Last Name" required>
                    <UInput
                      type="text"
                      placeholder="Enter Your Last Name"
                      v-model="form.last_name"
                    />
                  </UFormGroup>
                </div>
              </div>
              <UFormGroup label="Email Address" required>
                <UInput
                  type="email"
                  placeholder="Enter Your Email Address"
                  v-model="form.email"
                />
              </UFormGroup>

              <UFormGroup label="Subject" required>
                <UInput
                  type="text"
                  placeholder="Enter The Subject"
                  v-model="form.subject"
                />
              </UFormGroup>

              <UFormGroup label="Message" required>
                <UTextarea placeholder="Message..." v-model="form.message" />
              </UFormGroup>
              <div class="flex">
                <UButton label="Send Message" block @click="send" />
              </div>
            </form>
          </div>
        </div>
      </section>
      <!-- Contact section end -->
    </NuxtLayout>
  </div>
</template>
