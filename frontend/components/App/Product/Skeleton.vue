<template>
  <div class="w-full grid grid-cols-2 gap-3">
    <div class="flex flex-col justify-center items-center gap-3">
      <div class="w-full">
        <USkeleton class="w-32 h-32" :ui="{ rounded: 'rounded-full' }" />
      </div>
      <USkeleton class="w-[300px] h-[400px] rounded-lg" />
      <div class="flex flex-wrap gap-2">
        <USkeleton class="w-36 h-20 rounded-lg" />
        <USkeleton class="w-36 h-20 rounded-lg" />
        <USkeleton class="w-36 h-20 rounded-lg" />
      </div>
    </div>

    <div class="flex flex-col gap-1">
      <USkeleton class="w-full h-8 rounded-lg" />
      <USkeleton class="w-2/3 h-8 rounded-lg" />
      <USkeleton class="w-[200px] h-5 rounded-lg" />

      <div class="w-full flex justify-between my-8">
        <USkeleton class="w-20 h-8 rounded-lg" />
        <USkeleton class="w-20 h-8 rounded-lg" />
        <USkeleton class="w-20 h-8 rounded-lg" />
      </div>

      <div class="w-full flex flex-col gap-1 my-3">
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-2/3 h-3 rounded-lg" />
      </div>

      <div class="w-full flex flex-col gap-1 my-3">
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-2/3 h-3 rounded-lg" />
      </div>

      <div class="w-full flex flex-col gap-1 my-3">
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-full h-3 rounded-lg" />
        <USkeleton class="w-2/3 h-3 rounded-lg" />
      </div>
    </div>
  </div>
</template>
