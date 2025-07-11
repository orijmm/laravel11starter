<template>
    <a :href="`https://wa.me/${phone}?text=Hola%2C%20quiero%20más%20información`" target="_blank"
        class="position-fixed bottom-0 start-0 m-3 btn btn-success d-flex align-items-center justify-content-center rounded-circle shadow"
        style="width: 50px; height: 50px; z-index: 1050;" aria-label="WhatsApp">
        <i class="uil uil-whatsapp font-15rem" ></i>
    </a>
</template>

<script>

export default {
  props: {
    phone: {
      type: String,
      default: '',
    }
  }
}
</script>
