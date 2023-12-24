<script setup>
const { data: user, pending } = await useApiFetch("/api/user");
</script>

<template>
  <div>
    <div v-if="pending">Loading...</div>
    <div v-if="user">
      <h1>Home Page</h1>
      {{ user }}
    </div>
    <div v-else>
      <h1>Home Page</h1>
      <p>You are not logged in.</p>
    </div>
    <PrimaryLink to="/login" text="Login" />
    <PrimaryLink to="/app/profile" text="profile" />
  </div>
</template>
