<template>
  <footer class="bg-gray">
    <div class="container py-13 py-md-15">
      <div class="row gy-6 gy-lg-0">
        <div class="col-md-6 col-lg-4">
          <div class="widget">
            <!-- <img class="mb-4" src="/assets/img/logo-dark.png" srcset="/assets/img/logo-dark@2x.png 2x" alt="imgfooter" /> -->
            <h1>{{ menus.webdata.name_company ?? '' }}</h1>
            <p class="mb-4">
              © {{ new Date().getFullYear() }} {{ menus.webdata.name_company ?? '' }}.
              <br class="d-none d-lg-block" />All rights reserved.
            </p>
            <nav class="nav social">
              <FootersComponentsSocials />
            </nav>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="widget">
            <h4 class="widget-title mb-3">{{ trans('global.pages.contact_us') }}</h4>
            <address class="pe-xl-15 pe-xxl-17">
              {{ menus.webdata.address ?? '' }}
            </address>
            <a :href="`mailto:${menus.webdata.email}`" class="link-body">{{ menus.webdata.email ?? '' }}</a><br />
            {{ menus.webdata.phone ?? '' }}<br>
            <Socials :webdata="menus.webdata"/>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <div class="widget">
            <h4 class="widget-title mb-3">{{ trans('global.pages.newsletter') }}</h4>
            <p class="mb-5">
              {{ trans('global.phrases.newsletter_text') }}
            </p>
            <div class="newsletter-wrapper">
              <div id="mc_embed_signup2">
                <form @submit.prevent="() => { }" class="validate">
                  <div id="mc_embed_signup_scroll2">
                    <div class="mc-field-group input-group form-floating">
                      <input type="email" value="" name="email" class="required email form-control"
                        :placeholder="trans('users.labels.email')" />
                      <label for="email">{{ trans('users.labels.email') }}</label>
                      <input type="submit" :value="trans('users.labels.join')" name="subscribe" id="mc-embedded-subscribe2"
                        class="btn btn-primary" />
                    </div>
                    <div id="mce-responses2" class="clear">
                      <div class="response" id="mce-error-response2" style="display: none"></div>
                      <div class="response" id="mce-success-response2" style="display: none"></div>
                    </div>
                    <div style="position: absolute; left: -5000px" aria-hidden="true">
                      <input type="text" name="b_ddc180777a163e0f9f66ee014_4b1bcfa0bc" tabindex="-1" value="" />
                    </div>
                    <div class="clear"></div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <Scrolltop />
</template>

<script>
import { trans } from "@/helpers/i18n";

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
