<template>
  <footer class="bg-navy border-top">
    <div class="container py-8 py-md-10">
      <div class="row gy-6 gy-lg-0">
        <div class="col-12 col-md-6 col-lg-3">
          <div class="widget w-75">
            <img class="img-fluid" :src="menus.logo2" alt="imgfooter" />
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-9">
          <div class="row">
            <div class="col-md-6 col-lg-3">
              <div class="widget">
                <h4 class="widget-title mb-3">{{ trans('global.pages.company2') }}</h4>
                <address class="display-6">
                  <router-link class="nav-link" to="/por-que-visual-core">{{ trans('global.phrases.why_visualcore') }}
                  </router-link>
                </address>
                <address class="display-6">
                  <router-link class="nav-link" to="/abousus">{{ trans('global.phrases.about_us') }}
                  </router-link>
                </address>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="widget">
                <h4 class="widget-title mb-3">{{ trans('global.pages.contact_us') }}</h4>
                <address v-if="menus.webdata?.email" class="pe-xl-15 pe-xxl-17">
                  {{ menus.webdata.email ?? '' }}
                </address>
                <address v-if="menus.webdata?.phone" class="pe-xl-15 pe-xxl-17">
                  {{ menus.webdata.phone ?? '' }}
                </address>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="widget">
                <h4 class="widget-title mb-3">{{ trans('global.pages.follow_us') }}</h4>
                <address class="display-6">
                  <router-link class="nav-link" to="#">{{ trans('users.labels.linkeding') }}
                  </router-link>
                </address>
                <address class="display-6">
                  <router-link class="nav-link" to="#">{{ trans('users.labels.instagram') }}
                  </router-link>
                </address>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="widget">
                <h4 class="widget-title mb-3">{{ trans('global.pages.resources') }}</h4>
                <address class="display-6">
                  <router-link class="nav-link" to="/blog">{{ trans('global.pages.blog') }}
                  </router-link>
                </address>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <p class="m-4">
            © {{ new Date().getFullYear() }} {{ menus.webdata.name_company ?? '' }}. All rights reserved.
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- <Scrolltop /> -->
  <WhatsappStick :phone="menus.webdata.phone" />

</template>

<script>
import { trans } from "@/helpers/i18n";
import WhatsappStick from "../../template/components/base/WhatsappStick.vue";

export default {
  props: {
    menus: {
      type: Object,
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
