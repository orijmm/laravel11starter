<template>
  <section id="snippet-1" class="wrapper bg-light wrapper-border">
    <div class="container pt-15 pt-md-17 pb-13 pb-md-15">
      <div class="row gy-10 gy-sm-13 gx-lg-3 align-items-center">
        <div class="col-12 col-lg-5 position-relative">
          <div class="shape bg-dot primary rellax w-17 h-21" data-rellax-speed="1" style="top: -2rem; left: -1.9rem">
          </div>
          <div class="shape rounded bg-soft-primary rellax d-md-block" data-rellax-speed="0"
            style="bottom: -1.8rem; right: -1.5rem; width: 85%; height: 90%"></div>
          <figure class="rounded" >
            <img :src="img[0]" v-if="img.length" alt="websitep" />
            <NoImage v-else />
          </figure>
        </div>
        <div class="col-12 col-lg-6 offset-lg-1 text-justify">
          <h2 class="h1 mb-3">{{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}</h2>
          <p v-if="content[1]?.text" class="lead fs-lg mb-6">
            {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
          </p>
          <div v-for="(item, i) in groupedList" class="d-flex flex-row mb-6">
            <div>
              <span class="icon btn btn-circle btn-primary pe-none me-5">
                <span class="number fs-18">{{ item.number }}</span>
              </span>
            </div>
            <div>
              <h4 class="mb-1">{{ item.title }}</h4>
              <p class="mb-0">{{ item.description }}</p>
            </div>
          </div>
        </div>
      </div>
      <div v-if="img.length > 1" class="row mt-10">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5>{{ trans('global.phrases.design_diversity') }}</h5>
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
import { onMounted, ref } from "vue";

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
    const groupedList = ref([]);
    onMounted(() => {
      const contentList = props.content.slice(2);
      for (let i = 0; i < contentList.length; i += 3) {
        groupedList.value.push({
          number: contentList[i].text,
          title: contentList[i + 1].text,
          description: contentList[i + 2].text,
        });
      }
    });

    return {
      trans,
      groupedList
    }
  }
}
</script>