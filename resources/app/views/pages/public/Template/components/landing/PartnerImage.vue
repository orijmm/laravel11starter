<template>
  <div>
    <img :src="getImageUrl('partner/'+img)" class="sm:w-1/2 lg:w-72 mx-auto" alt="" />
  </div>
</template>
<script>
export default {
  props: {
    img: {
      type: String,
      default: '',
    },
  },
  setup() {
    const getImageUrl = (name) => {
      return new URL(`../../assets/img/${name}`, import.meta.url).href
    }

    return {
      getImageUrl
    }
  }
}
</script>
