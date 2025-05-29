<template>
  <div class="container pb-15 pb-md-17 mt-0 mt-lg-8 mt-xl-10 mt-xxl-10">
    <div v-if="services" class="row gx-md-5 gy-5 mb-10">
      <div class="col d-flex" v-for="(service, i) in services" :key="service.id">
        <div class="card shadow-lg">
          <div class="card-body" data-aos="fade-up" data-aos-once="true" :data-aos-delay="100 + i * 100">
            <div class="icon-svg" :class="service.icon_color_class"
              :style="{ '-webkit-mask-image': `url(${service.icon})`, 'mask-image': `url(${service.icon})` }"></div>
            <h4>{{ service.title }}</h4>
            <p class="mb-2">{{ service.description }}</p>
            <a v-if="service.link" :href="service.link" class="more hover" :class="service.link_color_class">{{
              service.link }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { trans } from "@/helpers/i18n";

export default {
  props: {
    content: {
      type: [Array],
      default: [],
    },
    services: {
      type: [Array],
      default: [],
    },
    img: {
      type: String,
      default: [],
    }
  },
  setup(props) {

    return {
      trans,
    }
  }
}
</script>
