<template>
  <div v-if="!loaded" class="page-loader">
  </div>
</template>

<script setup>
defineProps(["loaded"]);
</script>

<style lang="scss" scoped></style>
