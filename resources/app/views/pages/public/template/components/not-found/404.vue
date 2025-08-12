<template>
  <section class="wrapper bg-light">
    <div class="container pt-12 pt-md-14 pb-14 pb-md-16">
      <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto">
          <div class="mb-10 text-center">
            <img
              width="400px"
              src="/assets/img/illustrations/error404.jpg"
              alt="error404"
            />
          </div>
        </div>
        <div class="col-lg-8 col-xl-7 col-xxl-6 mx-auto text-center">
          <h1 class="mb-3">{{ trans('global.phrases.page_no_found') }}</h1>
          <p class="lead mb-7 px-md-12 px-lg-5 px-xl-7">
            {{ trans('global.phrases.page_no_found_tryother') }}
          </p>
          <router-link to="/" class="btn btn-primary rounded-pill"
            >{{ trans('users.labels.homepage') }}</router-link
          >
        </div>
      </div>
    </div>
  </section>
</template>

<script>

import { trans } from "@/helpers/i18n";

export default {
    name: "404error",
    setup() {
        return {
            trans
        };
    },
};
</script>


