<template>
  <section class="wrapper image-wrapper-noposition bg-rightbottom bg-xs-none bg-md-none"
    :style="{ backgroundImage: `url(${img[0] ?? '/assets/img/photos/bg38.jpg'})` }">
    <div class="container pt-17 pb-5 pb-lg-15 py-sm-17 py-xxl-20">
      <div class="row">
        <div class="col-12 col-lg-5 d-none d-lg-block"></div>
        <div class="col-12 col-lg-7">
          <h2 class="display-1 fs-56 mb-5 ls-xs pe-xl-5 pe-xxl-0  text-center">
            <span v-if="content[1]?.text" class="text-navy">{{ content[1]?.text ??
              trans('global.phrases.hasto_add_content') }}</span>
            <span v-if="content[2]?.text">&nbsp;{{ content[2]?.text ?? trans('global.phrases.hasto_add_content')
              }}</span>
            <span v-if="content[3]?.text" class="text-navy">&nbsp;{{ content[3]?.text ??
              trans('global.phrases.hasto_add_content') }}</span>
          </h2>
          <p class="lead fs-23 lh-sm mb-7 pe-lg-5 pe-xl-5 pe-xxl-0  text-center">
            <span v-if="content[4]?.text" class="">{{ content[4]?.text ?? trans('global.phrases.hasto_add_content')
              }}</span>
          </p>
          <div class="display-5 pt-5 pt-lg-10 text-center text-lg-end" v-if="content[5]?.text">
            <a v-smooth-scroll="{ offset: -80 }" data-aos="flip-down" data-aos-delay="150" class="btn btn-md btn-primary rounded-pill"
              :href="`#section-${extradata.page_name}-contact`">
              {{ content[5]?.text ?? trans('global.phrases.hasto_add_content') }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { trans } from "@/helpers/i18n";

export default {
  props: {
    content: {
      type: [Array],
      default: [],
    },
    img: {
      type: String,
      default: [],
    },
    extradata: {
      type: String,
      default: [],
    }
  },
  setup(props) {

    return {
      trans
    }
  }
}
</script>
