<script setup>
const cart_store = useCartStore();
const is_loading = ref(false);
const items = ref([]);
onMounted(() => {
  loadCart();
});

async function loadCart() {
  is_loading.value = true;
  const { data } = await useApiFetch("/api/cart", {
    method: "POST",
    body: {
      cart: cart_store.cart,
    },
  });
  if (data) {
    items.value = data.cart;
  }
  is_loading.value = false;
}

function remove(id) {
  cart_store.remove([id]);
  items.value = items.value.filter((item) => item._id !== id);
  useNotifications().value.push({
    type: "success",
    message: "Item removed from the cart",
  });
}

function removeAll() {
  const ids = items.value.map((item) => item._id);
  cart_store.remove(ids);
  items.value = [];
  useNotifications().value.push({
    type: "success",
    message: "All items removed from the cart",
  });
}
</script>

<template>
  <div>
    <NuxtLayout name="shop">
      <div class="flex justify-center py-20">
        <div class="container flex flex-col pt-10 px-5 md:px-0">
          <div class="flex justify-between items-center px-5">
            <div class="lg:col-span-1">
              <h1 class="main-heading">Your Cart</h1>
            </div>
            <div class="hidden lg:flex justify-end">
              <UButton to="/shop">Continue Shopping</UButton>
            </div>
          </div>
          <div class="w-full grid grid-cols-2 mt-5 gap-5" v-if="is_loading">
            <div class="flex flex-col gap-3">
              <USkeleton class="w-full h-[200px] rounded-lg" />
              <USkeleton class="w-full h-[200px] rounded-lg" />
              <USkeleton class="w-full h-[200px] rounded-lg" />
            </div>
            <div class="flex">
              <USkeleton class="w-full h-[320px] rounded-lg" />
            </div>
          </div>
          <div
            v-else-if="items.length == 0"
            class="col-span-full flex justify-center mt-5"
          >
            <div
              class="w-full md:w-2/3 lg:w-1/2 flex flex-col bg-primary-light dark:bg-primary-dark-transparent rounded shadow-lg dark:shadow-black overflow-hidden"
            >
              <div
                class="w-full h-[200px] bg-cover bg-center bg-[url(/img/superman-and-darkseid.png)]"
              ></div>
              <div class="w-full p-5 lg:p-8 gap-y-2">
                <div class="text-center text-lg font-bold">
                  Your cart is empty
                </div>
                <div class="text-center">
                  <UButton to="/shop">Continue Shopping</UButton>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full grid grid-cols-2 mt-5 gap-5" v-else>
            <div
              class="col-span-full lg:col-span-1 flex flex-col gap-3 order-2 lg:order-1"
            >
              <ShopCartItem
                v-for="item in items"
                :key="item"
                :id="item._id"
                :name="item.name"
                :publisher="item.publisher.name"
                :image="item.images[0]"
                :product_price="item.price"
                :has_discount="item.has_discount"
                :discount="item.discount"
                rating="8.5"
                favourite="2"
                buyers="10"
                @onremove="remove"
              />
            </div>
            <div class="col-span-full lg:col-span-1 order-1 lg:order-2">
              <div
                class="w-full flex flex-col bg-primary-light dark:bg-primary-dark-transparent rounded shadow-lg dark:shadow-black overflow-hidden"
              >
                <div
                  class="w-full h-[200px] bg-cover bg-center bg-[url(/img/superman-and-darkseid.png)]"
                ></div>
                <div class="w-full p-5 lg:p-8 gap-y-2">
                  <div class="grid grid-cols-2">
                    <div class="font-bold uppercase">Subtotal:</div>
                    <div>LKR. 12000.00</div>

                    <div class="font-bold uppercase">Discount:</div>
                    <div>LKR. 2000.00</div>

                    <div class="font-bold uppercase">Total:</div>
                    <div class="font-bold uppercase">LKR. 10000.00</div>
                  </div>
                  <div class="grid grid-cols-12 gap-3 mt-5">
                    <div class="col-span-full md:col-span-8">
                      <UButton
                        block
                        color="black"
                        size="lg"
                        icon="material-symbols:shopping-cart-checkout-sharp"
                      >
                        Checkout
                      </UButton>
                    </div>
                    <div class="col-span-full md:col-span-4">
                      <UButton
                        block
                        color="gray"
                        size="lg"
                        icon="system-uicons:reset-forward"
                        @click="removeAll"
                      >
                        Reset Cart
                      </UButton>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </NuxtLayout>
  </div>
</template>
