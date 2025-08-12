<template>
  <div class="row g-3 p-3 p-md-1">
    <div class="col-12 col-xl-10 col-xxl-9 mx-auto">
      <div class="pb-11 py-lg-13 ps-lg-7 pe-xxl-4">
        <h2 class="fs-15 text-uppercase text-muted mb-3 text-center">{{ content[0]?.text
          ??
          trans('global.phrases.hasto_add_content') }}</h2>
        <h5 class="display-5 mb-5 mb-lg-10 text-navy text-center">
          <span v-if="content[1]?.text">{{ content[1]?.text ??
            trans('global.phrases.hasto_add_content') }}</span>
          <span v-if="content[2]?.text" class="text-bold">&nbsp;{{ content[2]?.text ??
            trans('global.phrases.hasto_add_content')
            }}</span>
          <span v-if="content[3]?.text">&nbsp;{{ content[3]?.text ??
            trans('global.phrases.hasto_add_content')
            }}</span>
          <span v-if="content[4]?.text" class="text-bold">&nbsp;{{ content[4]?.text ??
            trans('global.phrases.hasto_add_content') }}</span>
        </h5>
        <div class="row g-5 align-items-center" v-for="(service, i) in services" :key="service.id">
          <!-- Fila par (índice 0, 2, 4...) → Imagen primero -->
          <template v-if="i % 2 === 0">
            <div class="col-12 col-md-7">
              <div class="d-flex">
                <div class="icon-pinred-bg text-red">{{ i + 1 }}</div>
                <div>
                  <h4 class="display-2 text-navy">{{ service.title }}</h4>
                  <p class="mb-0 text-justify">{{ service.description }}</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-5 d-none d-md-block">
              <img class="img-fluid" v-if="service.img[0]" :src="service.img[0]" />
              <NoImage v-else />
            </div>
          </template>

          <!-- Fila impar (índice 1, 3, 5...) → Texto primero -->
          <template v-else>
            <div class="col-12 col-md-5 d-none d-md-block">
              <img class="img-fluid" v-if="service.img[0]" :src="service.img[0]" />
              <NoImage v-else />
            </div>
            <div class="col-12 col-md-7">
              <div class="d-flex">
                <div class="icon-pinred-bg text-red">{{ i + 1 }}</div>
                <div>
                  <h4 class="display-2 text-navy">{{ service.title }}</h4>
                  <p class="mb-0 text-justify">{{ service.description }}</p>
                </div>
              </div>
            </div>
          </template>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import { trans } from "@/helpers/i18n";
import NoImage from '@/views/pages/private/website/components/noImage';

export default {
  components: { NoImage },
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
