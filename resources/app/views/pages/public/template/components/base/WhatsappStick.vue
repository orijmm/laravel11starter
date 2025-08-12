<template>
  <a
    :href="`https://wa.me/${phone}?text=Hola%2C%20quiero%20más%20información`"
    target="_blank"
    v-tippy="{
      content: `<div class='text-bold'>${trans('global.actions.need_help')}</div> ${trans('global.actions.talk_with_us')}`,
      allowHTML: true,
      placement: 'right',
      animation: 'shift-away',
      theme: 'light'
    }"
    class="position-fixed bottom-0 end-0 m-3 rounded-circle shadow-xxl"
    style="width: 50px; height: 50px; z-index: 1050;"
    aria-label="WhatsApp"
  >
    <img
      src="/assets/img/home/icono-whatsapp.png"
      alt="WhatsApp"
      class="w-100"
    />
  </a>
</template>
<script>
  
import { trans } from "@/helpers/i18n";
import { directive as VTippy } from "vue-tippy";
import "tippy.js/dist/tippy.css";
import "tippy.js/themes/light.css"; // si usas ese theme

export default {
  directives: {
    tippy: VTippy,
  },
  props: {
    phone: {
      type: String,
      default: '',
    }
  },
  setup(props) {

    return {
      trans
    }
  }
}
</script>
