<template>
  <div class="py-3">
    <!-- Social media links using map -->
    <a v-if="webdata.twitter" target="_blank" class="px-1" :href="webdata.twitter ?? '#'">
      <i class="uil uil-twitter"></i>
    </a>
    <a v-if="webdata.facebook" target="_blank" class="px-1" :href="webdata.facebook ?? '#'">
      <i class="uil uil-facebook-f"></i>
    </a>
    <a v-if="webdata.instagram" target="_blank" class="px-1" :href="webdata.instagram ?? '#'">
      <i class="uil uil-instagram"></i>
    </a>
    <a v-if="webdata.youtube" target="_blank" class="px-1" :href="webdata.youtube ?? '#'">
      <i class="uil uil-youtube"></i>
    </a>
  </div>
</template>

<script>

export default {
  props: {
    webdata: {
      type: Object,
      required: true,
      default: {},
    },
  }
};
</script>
