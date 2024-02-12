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
          <div class="w-full grid grid-cols-2 mt-5 gap-5">
            <div
              class="col-span-full lg:col-span-1 flex flex-col gap-3 order-2 lg:order-1"
            >
              <ShopCartItem
                v-for="item in 2"
                :key="item"
                :id="1"
                name="Batman Gotham Knight #1"
                publisher="DC Comics"
                image="batman-comic.png"
                rating="8.5"
                favourite="2"
                product_price="1000"
                offer_percentage="66"
                buyers="10"
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
