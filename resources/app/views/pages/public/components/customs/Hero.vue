<template>
  <section class="wrapper image-wrapper-noposition bg-leftbottom bg-xs-none bg-md-none"
    :style="{ backgroundImage: `url(${img[0] ?? '/assets/img/photos/bg38.jpg'})` }">
    <div class="container pt-17 pb-5 pb-lg-15 py-sm-17 py-xxl-20">
      <div class="row">
        <div class="col-12 col-lg-6 text-center">
          <h5 class="text-sky display-5 ps-xl-1">
            {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
          </h5>
          <h2 class="display-1 fs-56 mb-4 ls-xs pe-xl-5 pe-xxl-0">
            <span>{{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
          </h2>
          <p class="lead fs-23 lh-sm mb-7 pe-lg-5 pe-xl-5 pe-xxl-0">
            <span v-if="content[2]?.text" class="">{{ content[2]?.text ?? trans('global.phrases.hasto_add_content')
              }}</span>
            <span v-if="content[3]?.text" class="text-sky text-bold">&nbsp;{{ content[3]?.text ??
              trans('global.phrases.hasto_add_content') }}</span>
            <span v-if="content[4]?.text" class="">{{ content[4]?.text ?? trans('global.phrases.hasto_add_content')
              }}</span>
            <span v-if="content[5]?.text" class="text-sky text-bold">&nbsp;{{ content[5]?.text ??
              trans('global.phrases.hasto_add_content') }}</span>
            <span v-if="content[6]?.text" class="">&nbsp;{{ content[6]?.text ??
              trans('global.phrases.hasto_add_content') }}</span>
            <span v-if="content[7]?.text" class="text-sky text-bold">&nbsp;{{ content[7]?.text ??
              trans('global.phrases.hasto_add_content') }}</span>

          </p>
          <div class="pt-50">
            <a v-smooth-scroll data-aos="flip-down" data-aos-delay="150" class="btn btn-md btn-primary rounded-pill" href="#section-contactenos">
              {{ content[8]?.text ?? trans('global.phrases.hasto_add_content') }}
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
    }
  },
  setup(props) {

    return {
      trans
    }
  }
}
</script>
