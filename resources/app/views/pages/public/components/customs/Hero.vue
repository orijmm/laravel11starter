<template>
  <section
    class="wrapper image-wrapper bg-cover bg-image bg-xs-none bg-gray"
    :style="{ backgroundImage: `url(${img[0] ?? '/assets/img/photos/bg37.jpg'})` }"
  >
    <div class="container pt-17 pb-15 py-sm-17 py-xxl-20">
      <div class="row">
        <div class="col-12 col-sm-6 text-center text-sm-start">
          <h2
            class="display-1 fs-56 mb-4 mt-0 mt-lg-5 ls-xs pe-xl-5 pe-xxl-0"
            data-aos="fade-up"
            data-aos-once="true"
            data-aos-delay=""
          >
            {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
            <span class="text-bold">{{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
          </h2>
          <p
            class="lead fs-23 lh-sm mb-7 pe-lg-5 pe-xl-5 pe-xxl-0"
            data-aos="fade-up"
            data-aos-once="true"
            data-aos-delay="200"
          >
            {{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}
          </p>
          <div>
            <router-link
              data-aos="fade-up"
              data-aos-once="true"
              data-aos-delay="300"
              class="btn btn-lg btn-primary rounded"
              to="/"
              >{{ content[3]?.text ?? trans('global.phrases.hasto_add_content') }}</router-link
            >
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
