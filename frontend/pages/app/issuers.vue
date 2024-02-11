<script setup>
const is_add_issuer_open = ref(false);

const columns = [
  {
    label: "Name",
    key: "name",
    sortable: true,
  },
  {
    label: "Status",
    key: "status",
    sortable: true,
  },
  {
    label: "Issues",
    key: "issues",
    sortable: true,
  },
  {
    label: "Buyers",
    key: "buyers",
    sortable: true,
  },
  {
    label: "Action",
    key: "action",
    sortable: false,
  },
];
</script>

<template>
  <div>
    <NuxtLayout name="app">
      <div
        class="w-full p-5 lg:p-8 bg-primary-light dark:bg-primary-dark rounded-lg"
      >
        <div
          class="flex flex-col lg:flex-row items-center lg:items-start justify-between"
        >
          <AppHeading title="Comic Issuers" />

          <UButton
            label="Add An Issuer"
            color="black"
            icon="solar:add-circle-bold"
            @click="is_add_issuer_open = true"
          />
        </div>

        <div class="border border-slate-500/40 rounded-lg mt-5 px-2">
          <UTable :columns="columns" :rows="rows">
            <!-- custom columns start -->
            <template #name-data="{ row }">
              <div class="flex items-center gap-2 pr-5">
                <img
                  class="h-8"
                  :src="`/img/comics/batman-comic.png`"
                  :alt="row.issuer"
                />
                <div class="flex flex-col">
                  <h5 class="text-md">
                    {{ row.name }}
                  </h5>
                  <span class="text-xs font-semibold uppercase">
                    {{ row.issuer }}
                  </span>
                </div>
              </div>
            </template>

            <template #status-data="{ row }">
              <div class="capitalize">
                <UBadge
                  v-if="row.status == 'removed'"
                  color="red"
                  variant="subtle"
                >
                  {{ row.status }}
                </UBadge>
                <UBadge
                  v-else-if="row.status == 'hidden'"
                  color="yellow"
                  variant="subtle"
                >
                  {{ row.status }}
                </UBadge>
                <UBadge v-else color="green" variant="subtle">
                  {{ row.status }}
                </UBadge>
              </div>
            </template>

            <template #buyers-data="{ row }">
              <UBadge v-if="row.buyers < 20" color="red" variant="subtle">
                {{ row.buyers }} Buyers
              </UBadge>
              <UBadge
                v-else-if="row.buyers < 50"
                color="yellow"
                variant="subtle"
              >
                {{ row.buyers }} Buyers
              </UBadge>
              <UBadge v-else color="green" variant="subtle">
                {{ row.buyers }} Buyers
              </UBadge>
            </template>

            <template #action-data="{ row }">
              <UDropdown :items="items(row)">
                <UButton
                  color="gray"
                  variant="ghost"
                  icon="i-heroicons-ellipsis-horizontal-20-solid"
                  class="dark:hover:bg-secondary-dark/30"
                />
              </UDropdown>
            </template>
            <!-- custom columns end -->
          </UTable>

          <div
            class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
          >
            <!-- <UPagination
              v-model="page"
              :page-count="pageCount"
              :total="updated_comics.length"
            /> -->
          </div>
        </div>
        <USlideover v-model="is_add_issuer_open">
          <UCard
            class="flex flex-col flex-1 p-5 overflow-y-scroll"
            :ui="{
              body: { base: 'flex-1' },
              ring: '',
              background: 'dark:bg-transparent',
            }"
          >
            <template #header>
              <div class="flex">
                <h3 class="text-lg font-semibold">Add An Issuer</h3>
                <UButton
                  color="black"
                  icon="solar:close-circle-bold"
                  class="ml-auto"
                  variant="ghost"
                  @click="is_add_issuer_open = false"
                />
              </div>
            </template>

            <div class="my-3 flex flex-col gap-3">
              <UFormGroup label="Name" required>
                <UInput placeholder="Enter the name of the issuer" />
              </UFormGroup>
              <UFormGroup label="Logo" required>
                <FileUploader />
              </UFormGroup>
            </div>

            <template #footer>
              <div class="flex justify-end gap-3">
                <UButton
                  label="Reset"
                  color="gray"
                  icon="solar:restart-bold"
                />
                <UButton
                  label="Submit"
                  color="black"
                  icon="solar:add-circle-bold"
                  @click="is_add_issuer_open = false"
                />
              </div>
            </template>
          </UCard>
        </USlideover>
      </div>
    </NuxtLayout>
  </div>
</template>
