<template>
  <div class="violet-theme urbanist-font">
    <div class="content-wrapper">
      <HeadersHeader />
      <Hero />
      <Features />
      <Facts />
      <section class="wrapper bg-light">
        <div class="container py-16 py-md-18">
          <Testimonials />
        </div>
      </section>
      <Projects />
      <section class="wrapper bg-light">
        <div class="container mt-8 pb-16 pb-md-18">
          <Features2 />
        </div>
      </section>
    </div>
    <Footer2 />
  </div>
</template>
<script>

import { useRoute } from 'vue-router';
import { useAlertStore } from "@/stores";
import { onMounted, reactive } from 'vue';
import { getResponseError, prepareQuery } from "@/helpers/api";
import ModelService from '@/services/ModelService';
import SettingService from '@/services/SettingService';


export default {
  name: 'DefaultLayout',
  setup() {
    const service = new ModelService;
    const settings = new SettingService();
    const alertStore = useAlertStore();
    const route = useRoute();


    // Variables reactivas
    const menus = reactive({
      total: 0,
      data: [],
      logo: null,
      webdata: []
    });
    const page = reactive({
      sections: []
    });

    //metodos
    function fetchPage() {
      let page_id = typeof route.params.id != 'undefined' ? route.params.id : '';
      //Colocar menu-top como menu principal
      let query = prepareQuery({ search: 'menu-top' });
      service
        .index(query, 'menus/searchname')
        .then((response) => {
          menus.data = response.data.model.items;
          menus.total = response.data.model.length;
        })
        .catch((error) => {
          alertStore.error(getResponseError(error));
        });

      //page
      service
        .find(page_id, 'getpage')
        .then((response) => {
          page.sections = response.data.page.sections ?? [];
        })
        .catch((error) => {
          alertStore.error(getResponseError(error));
          console.log(error);
        });

      //Setting
      settings.find(1)
        .then((response) => {
          menus.logo = response.data.model.logo_thumb_url;
          menus.webdata = response.data.model;
        });
    }

    onMounted(() => {
      fetchPage();
    });

    return {
      menus,
      page
    }
  }
}
</script>
