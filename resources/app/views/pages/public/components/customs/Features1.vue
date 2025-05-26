<template>
  <section class="wrapper bg-light">
    <div class="container pb-15 pb-md-17 mt-0 mt-lg-8 mt-xl-10 mt-xxl-10">
      <!--/.row -->
      <div class="row">
        <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 mx-auto text-center">
          <h2 class="fs-16 text-uppercase text-muted mb-3">
            {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
          </h2>
          <h3 v-if="content[1]?.text" class="display-3 mb-10 px-xl-10 px-xxl-15">
            {{ content[1]?.text }}
            <span v-if="content[2]?.text" class="underline-3 style-2 yellow">
              {{ content[2]?.text}}
              </span>
            <span v-if="content[3]?.text">{{ content[3]?.text }}</span>
          </h3>
        </div>
        <!-- /column -->
      </div>
      <!-- /.row -->
      <ul class="nav nav-tabs nav-tabs-bg nav-tabs-shadow-lg d-flex justify-content-between nav-justified flex-lg-row flex-column">
        <li v-for="(service, i) in services" :key="`tabtitle-${i}`" class="nav-item">
          <div :class="`nav-link d-flex flex-row cursor-pointer ${activeTab == i ? 'active' : ''
            }`" @click="
              () => {
                activeTab = i;
              }
            ">
            <div>
                <div class="icon-svg icon-svg-sm solid-mono me-4" :class="service.icon_color_class"
                :style="{ '-webkit-mask-image': `url(${service.icon})`, 'mask-image': `url(${service.icon})` }"></div>
            </div>
            <div>
              <h4>{{ service.title }}</h4>
              <p>{{ service.description }}</p>
            </div>
          </div>
        </li>
      </ul>
      <!-- /.nav-tabs -->
      <div class="tab-content mt-6 mt-lg-8">
        <div v-for="(service, i) in services" :key="`tabconten-${i}`" :class="`tab-pane fade  ${activeTab == i ? 'show active' : ''}`">
          <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
            <div class="col-lg-6">
              <figure class="rounded shadow-lg">
                <img :src="service.img[0]" alt="imgfeatue" />
              </figure>
            </div>
            <!--/column -->
            <div class="col-lg-6">
              <h2 class="mb-3">{{ service.title }}</h2>
              <p class="ql-editor" v-html="service.content">
                
              </p>
            </div>
            <!--/column -->
          </div>
          <!--/.row -->
        </div>
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.container -->
  </section>
</template>

<script>
import { trans } from "@/helpers/i18n";
import { checklistItems, services4 } from "./data/features";
import { ref } from 'vue';

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
    const activeTab = ref(0);

    return {
      trans,
      activeTab,
      checklistItems,
      services4
    }
  }
}
</script>
