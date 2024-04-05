<template>
  <div class="flex items-center justify-center h-screen">
    <div class="flex flex-col items-center justify-center space-y-4">
      <Icon name="bx:bxs-check-circle" class="text-6xl text-green-500" />
      <h1 class="text-2xl font-bold">Payment successful</h1>
      <p class="text-sm text-gray-500">Thank you for your purchase</p>
      <Button @click="$router.push('/app/comics')" class="mt-4">
        Continue shopping
      </Button>
    </div>
  </div>
</template>
