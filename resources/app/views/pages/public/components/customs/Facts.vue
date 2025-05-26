<template>
  <section class="wrapper bg-gray">
    <div class="container py-15 py-md-17 pb-md-19">
      <div class="row align-items-center gy-8 mb-13">
        <div class="col-12 text-lg-start">
          <h2 class="fs-16 text-uppercase text-muted mb-3 text-justify">
            {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
          </h2>
          <h5 v-if="content[1]?.text" class="display-3 mb-0 pe-xl-10 pe-xxl-15 text-justify">
            <span class="dropcap text-primary"> {{ content[1]?.text[0] }}</span>
            <span>{{ content[1]?.text.slice(1) }}</span>
            <span class="underline-3 style-2 yellow">&nbsp;{{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}</span> 
            <span v-if="content[3]?.text">&nbsp;{{ content[3]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
          </h5>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
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
    setup() {
      return {
          trans
      }
    }
}
</script>

