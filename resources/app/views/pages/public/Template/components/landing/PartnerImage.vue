<template>
  <div>
    <img :src="img" class="sm:w-1/2 lg:w-72 mx-auto" alt="" />
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
    //Se usa si viene el nombre de la imagen
    // const getImageUrl = (name) => {
    //   return new URL(`../../assets/img/${name}`, import.meta.url).href
    // }

    return {
      // getImageUrl
    }
  }
}
</script>
