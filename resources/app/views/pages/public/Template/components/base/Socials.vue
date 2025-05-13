<template>
  <!-- Social media links using map -->
  <a v-if="webdata.twitter" target="_blank" :href="webdata.twitter ?? '#'">
    <i class="uil uil-twitter"></i>
  </a>
  <a v-if="webdata.facebook" target="_blank" :href="webdata.facebook ?? '#'">
    <i class="uil uil-facebook-f"></i>
  </a>
  <a v-if="webdata.instagram" target="_blank" :href="webdata.instagram ?? '#'">
    <i class="uil uil-instagram"></i>
  </a>
  <a v-if="webdata.youtube" target="_blank" :href="webdata.youtube ?? '#'">
    <i class="uil uil-youtube"></i>
  </a>
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
  // const socialMediaLinks = [
  //     { id: 1, href: props.webdata.twitter ?? "#", iconClass: "uil uil-twitter" },
  //     { id: 2, href: "#", iconClass: "uil uil-facebook-f" },
  //     { id: 3, href: "#", iconClass: "uil uil-dribbble" },
  //     { id: 4, href: "#", iconClass: "uil uil-instagram" },
  //     { id: 5, href: "#", iconClass: "uil uil-youtube" },
  //   ];
};
</script>
