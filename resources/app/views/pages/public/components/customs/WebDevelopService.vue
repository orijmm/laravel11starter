<template>
  <section id="snippet-1" class="wrapper bg-light wrapper-border">
    <div class="container pt-15 pt-md-17 pb-13 pb-md-15">
      <div class="row gy-10 gy-sm-13 gx-lg-3 align-items-center">
        <div class="col-md-8 col-lg-6 position-relative">
          <div class="shape bg-dot primary rellax w-17 h-21" data-rellax-speed="1" style="top: -2rem; left: -1.9rem">
          </div>
          <div class="shape rounded bg-soft-primary rellax d-md-block" data-rellax-speed="0"
            style="bottom: -1.8rem; right: -1.5rem; width: 85%; height: 90%"></div>
          <figure class="rounded" >
            <img :src="img[0]" v-if="img.length" alt="websitep" />
            <NoImage v-else />
          </figure>
        </div>
        <!--/column -->
        <div class="col-lg-5 col-xl-4 offset-lg-1">
          <h2 class="h1 mb-3">{{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}</h2>
          <p v-if="content[1]?.text" class="lead fs-lg mb-6">
            {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
          </p>
          <div v-if="content[2]?.text" class="d-flex flex-row mb-6">
            <div>
              <span class="icon btn btn-circle btn-primary pe-none me-5">
                <span class="number fs-18">{{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
              </span>
            </div>
            <div>
              <h4 class="mb-1">{{ content[3]?.text ?? trans('global.phrases.hasto_add_content') }}</h4>
              <p class="mb-0">{{ content[4]?.text ?? trans('global.phrases.hasto_add_content') }}</p>
            </div>
          </div>
          <div v-if="content[5]?.text" class="d-flex flex-row mb-6">
            <div>
              <span class="icon btn btn-circle btn-primary pe-none me-5">
                <span class="number fs-18">{{ content[5]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
              </span>
            </div>
            <div>
              <h4 class="mb-1">{{ content[6]?.text ?? trans('global.phrases.hasto_add_content') }}</h4>
              <p class="mb-0">{{ content[7]?.text ?? trans('global.phrases.hasto_add_content') }}</p>
            </div>
          </div>
          <div v-if="content[8]?.text" class="d-flex flex-row mb-6">
            <div>
              <span class="icon btn btn-circle btn-primary pe-none me-5">
                <span class="number fs-18">{{ content[8]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
              </span>
            </div>
            <div>
              <h4 class="mb-1">{{ content[9]?.text ?? trans('global.phrases.hasto_add_content') }}</h4>
              <p class="mb-0">{{ content[10]?.text ?? trans('global.phrases.hasto_add_content') }}</p>
            </div>
          </div>
        </div>
      </div>
      <div v-if="img.length > 1" class="row mt-10">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row gy-6">
                <Carousel :images="img.slice(1)" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
      trans
    }
  }
}
</script>