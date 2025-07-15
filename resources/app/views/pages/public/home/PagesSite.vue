<template>
  <div class="sky-theme">
    <div class="content-wrapper">
      <HeadersHome :menus="menus" />
      
      <Content :page="page" :extradata="extradata" class="top-content"/>

    </div>
    <Footer2 :menus="menus" />
  </div>
</template>

<script>
import { useRoute } from 'vue-router';
import { useAlertStore } from "@/stores";
import { onMounted, reactive, watch } from 'vue'; // <-- Importa watch
import { getResponseError, prepareQuery } from "@/helpers/api";
import ModelService from '@/services/ModelService';
import SettingService from '@/services/SettingService';
import { injectSvg } from "../template/utlis/injextSvg";

export default {
  name: 'DefaultLayout',
  setup() {
    const service = new ModelService();
    const settings = new SettingService();
    const alertStore = useAlertStore();
    const route = useRoute();
    injectSvg();

    const menus = reactive({
      total: 0,
      data: [],
      logo: null,
      logo2: null,
      webdata: []
    });

    const page = reactive({
      sections: [],
      extradata: []
    });

    function fetchPage() {
      const page_id = route.params.id || '';
      
      // Menú
      const query = prepareQuery({ search: 'menu-top' });
      service.index(query, 'menus/searchname')
        .then((response) => {
          menus.data = response.data.model.items;
          menus.total = response.data.model.length;
        })
        .catch((error) => {
          alertStore.error(getResponseError(error));
        });

      // Página
      service.find(page_id, 'getpage')
        .then((response) => {
          page.sections = response.data.page.sections ?? [];
          page.extradata = response.data.extradata ?? [];
        })
        .catch((error) => {
          alertStore.error(getResponseError(error));
          console.log(error);
        });

      // Configuraciones
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

    // Observa el cambio en el parámetro de la ruta
    watch(() => route.params.id, () => {
      fetchPage();
    });

    return {
      menus,
      page
    };
  }
}
</script>