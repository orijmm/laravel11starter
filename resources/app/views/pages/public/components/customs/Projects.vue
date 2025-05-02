<template>
  <div class="container pb-13 pb-md-15">
    <div class="row">
      <div class="col-lg-9 col-xl-8 col-xxl-7 mx-auto text-center">
        <h2 class="fs-15 text-uppercase text-muted mb-3">{{ content[0]?.text ??
          trans('global.phrases.hasto_add_content') }}</h2>
        <h3 class="display-4 mb-10">
          {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
          <span class="underline-3 style-2 yellow">{{ content[2]?.text ?? trans('global.phrases.hasto_add_content')
          }}</span> {{ content[3]?.text ?? trans('global.phrases.hasto_add_content') }}
        </h3>
      </div>
      <!-- /column -->
    </div>
    <!-- /.row -->
    <div class="swiper-container grid-view mb-6">
      <Swiper :space-between="30" :pagination="{ el: '.pbutton2', clickable: true }" :modules="[Pagination]"
        :grab-cursor="true" :breakpoints="{
          500: { slidesPerView: 1 },
          768: { slidesPerView: 2 },
          1024: { slidesPerView: 3 },
          1200: { slidesPerView: 3 },
        }">
        <SwiperSlide v-for="(elm, i) in extradata.projects" :key="i">
          <figure class="rounded mb-6">
            <img :src="elm.img_src" :alt="elm.img_alt" />
          </figure>
          <div class="project-details d-flex justify-content-center flex-column">
            <div class="post-header">
              <h2 class="post-title h3">
                <router-link to="/single-project" class="link-dark">{{
                  elm.title
                  }}</router-link>
              </h2>
              <div class="post-category text-ash">{{ elm.category }}</div>
            </div>
            <!-- /.post-header -->
          </div>
        </SwiperSlide>
      </Swiper>
      <div class="swiper-controls">
        <div
          class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal pbutton2">
        </div>
      </div>

      <!-- /.swiper -->
    </div>
    <!-- /.swiper-container -->
  </div>
</template>

<script setup>



</script>

<script>
import { trans } from "@/helpers/i18n";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper/modules";
import { ref, onMounted } from 'vue';

export default {
  components: {
    Swiper,
    SwiperSlide,
  },
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
      trans,
      Pagination,
    }
  }
}
</script>
