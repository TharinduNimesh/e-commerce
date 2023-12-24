<script setup>
const user = await useAuth();
</script>

<template>
    <div>
        {{ user }}
    </div>
</template>
