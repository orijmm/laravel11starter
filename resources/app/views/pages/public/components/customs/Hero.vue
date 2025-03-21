<template>
    <div class="container pt-17 pb-19 pt-md-18 pb-md-17 text-center">
      <div class="row">
        <div class="col-lg-8 col-xl-7 col-xxl-6 mx-auto">
          <h1 class="display-1 text-white fs-60 mb-4 px-md-15 px-lg-0" data-aos="fade-up" data-aos-once="true"
            data-aos-delay="">
            {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
            <span class="underline-3 style-2 yellow">{{ content[1]?.text ?? trans('global.phrases.hasto_add_content')
              }}</span>
          </h1>
          <p class="lead fs-24 text-white lh-sm mb-7 mx-md-13 mx-lg-10" data-aos="fade-up" data-aos-once="true"
            data-aos-delay="200">
            {{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}.
          </p>
          <div data-aos="fade-up" data-aos-once="true" data-aos-delay="300">
            <router-link class="btn btn-white rounded mb-10 mb-xxl-5" to="/">{{ content[3]?.text ??
              trans('global.phrases.hasto_add_content') }}</router-link>
          </div>
        </div>
        <!-- /column -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
    <div class="overflow-hidden">
      <div class="divider text-light mx-n2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 60">
          <path fill="currentColor" d="M0,0V60H1440V0A5771,5771,0,0,1,0,0Z" />
        </svg>
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
