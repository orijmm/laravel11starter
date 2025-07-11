<template>
  <div>
    <div class="container">
      <div data-aos="flip-right" data-aos-delay="200" class="col-lg-6 position-lg-absolute top-0 start-0 image-wrapper bg-image bg-cover h-100"
        :style="{ backgroundImage: `url(${img[0] ?? '/assets/img/photos/bg38.jpg'})` }">
        <div class="divider text-gray divider-v-end d-none d-lg-block">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54 1200">
            <g />
            <g>
              <g>
                <polygon fill="currentColor" points="48 0 0 0 48 1200 54 1200 54 0 48 0" />
              </g>
            </g>
          </svg>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row gx-0">
        <div class="col-lg-6 ms-auto">
          <div class="pt-13 pb-15 pb-md-17 py-lg-16 ps-lg-7 pe-xxl-4">
            <h2 class="fs-15 text-uppercase text-muted mb-3"  data-aos="flip-down" data-aos-delay="200">{{ content[0]?.text ??
                    trans('global.phrases.hasto_add_content') }}</h2>
            <h3 class="display-3 ls-sm mb-7 mb-lg-10"  data-aos="flip-down" data-aos-delay="200">
              {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
            </h3>
            <div class="row gy-8">
              <div v-for="(service, i) in services" :key="service.id" class="col-12 col-lg-6 d-flex"
              data-aos="flip-down" data-aos-once="true" :data-aos-delay="200 + i * 100">
                <div>
                  <div class="icon-svg icon-svg-xs  me-5 mt-1" :class="service.icon_color_class"
                    :style="{ '-webkit-mask-image': `url(${service.icon})`, 'mask-image': `url(${service.icon})` }">
                  </div>
                </div>
                <div>
                  <h4 class="fs-20 ls-sm">{{ service.title }}</h4>
                  <p class="mb-0 text-justify">
                    {{ service.description }}
                  </p>
                </div>
              </div>
            </div>
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
