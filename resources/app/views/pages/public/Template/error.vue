<template>
  <div class="content-wrapper">
    <HeadersHeader1 bg="bg-light" />
    <template v-if="props.error.statusCode == 404">
      <NotFound404 />
    </template>
    <template v-else>
      <div
        class="fs-22 mt-50 mb-50 ml-10"
        style="min-height: calc(100vh - 200px)"
      >
        An error found with {{ props.error.statusCode }} status code
      </div>
    </template>
  </div>
  <FooterIndex />
</template>

<script setup>
const props = defineProps({
  error: Object,
});

</script>

<style lang="css">
@import "./public/assets/css/plugins.css";
</style>
<style lang="scss">
@import "./public/assets/scss/style.scss";
</style>
