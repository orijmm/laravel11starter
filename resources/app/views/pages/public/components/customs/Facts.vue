<template>
  <section class="wrapper bg-gray">
    <div class="container py-15 py-md-17 pb-md-19">
      <div class="row align-items-center gy-8 mb-13">
        <div class="col-12 text-center text-lg-start">
          <h2 class="fs-16 text-uppercase text-muted mb-3">
            {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
          </h2>
          <h3 class="display-3 mb-0 pe-xl-10 pe-xxl-15">
            {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
            <span class="underline-3 style-2 yellow">{{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}</span> {{ content[3]?.text ?? trans('global.phrases.hasto_add_content') }}
          </h3>
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

