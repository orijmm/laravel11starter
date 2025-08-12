<template>
  <div class="sky-theme">
    <div class="content-wrapper">
      <HeadersHome :menus="menus" />
      
      <Content :page="page" :extradata="extradata" />

    </div>
    <Footer2 :menus="menus" />
  </div>
</template>

<script>

import { useRoute } from 'vue-router';
import { useAlertStore, useGlobalStateStore } from "@/stores";
import { onMounted, reactive } from 'vue';
import { getResponseError, prepareQuery } from "@/helpers/api";
import ModelService from '@/services/ModelService';
import SettingService from '@/services/SettingService';
import { injectSvg } from "../template/utlis/injextSvg";

export default {
  name: 'DefaultLayout',
  setup() {
    const service = new ModelService;
    const settings = new SettingService();
    const alertStore = useAlertStore();
    const route = useRoute();
    injectSvg();
    // Variables reactivas
    const menus = reactive({
      total: 0,
      data: [],
      logo: null,
      logo2: null,
      webdata: []
    });
    const page = reactive({
      sections: [],
      extradata: [],
      loaded: false 
    });

    //metodos
    function fetchPage() {
      let page_slug = typeof route.params.slug != 'undefined' ? route.params.slug : '';
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
        .find(page_slug, 'getpage')
        .then((response) => {
          page.sections = response.data.page.sections ?? [];
          page.extradata = response.data.extradata ?? [];
          const globalStateStore = useGlobalStateStore();
          globalStateStore.setUILoading(false);
        })
        .catch((error) => {
          alertStore.error(getResponseError(error));
          console.log(error);
        });

      //Setting
      settings.find(1)
        .then((response) => {
          menus.logo = response.data.model.logo_url;
          menus.logo2 = response.data.model.logo_url2;
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
