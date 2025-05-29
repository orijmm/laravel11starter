<template>
  <div class="container py-15 py-md-17 pb-md-19">
    <div class="row align-items-center gy-8 mb-13">
      <div class="col-12 text-lg-start" data-aos="fade-up" data-aos-once="true" data-aos-delay="300"
        data-aos-duration="2000">
        <h2 class="fs-16 text-uppercase text-muted mb-3 text-justify">
          {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
        </h2>
        <h5 v-if="content[1]?.text" class="display-3 mb-0 pe-xl-10 pe-xxl-15 text-justify">
          <span>{{ content[1]?.text }}</span>
          <span class="underline-3 style-2 yellow">&nbsp;{{ content[2]?.text ??
            trans('global.phrases.hasto_add_content') }}</span>
          <span v-if="content[3]?.text">&nbsp;{{ content[3]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
        </h5>
      </div>
    </div>
  </div>
</template>

<script>
import { trans } from "@/helpers/i18n";
import { onMounted } from "vue";
import AOS from 'aos';

export default {
  props: {
    content: {
      type: [Array],
      default: [],
    },
    img: {
      type: String,
      default: [],
    }
  },
  setup() {
    onMounted(() => {
      AOS.refresh(); // actualiza AOS tras cargar contenido
    });
    return {
      trans
    }
  }
}
</script>
