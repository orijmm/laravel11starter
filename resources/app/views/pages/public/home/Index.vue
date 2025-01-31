<template>
  <div class="min-h-screen font-sans antialiased relative">
    <div class="relative">
      <div class="absolute top-0 left-0 w-full h-[125vh] sm:h-[225vh] lg:h-[125vh] cover-gradient-2 sm:cover-gradient">
      </div>
      <BaseNavbar :menus="menus" />

      <main class="text-neutral-800">
        <Content :page="page" />
      </main>

      <BaseFooter />
    </div>
  </div>
</template>
<script>
import BaseNavbar from '@/views/pages/public/template/components/base/Navbar';
import BaseFooter from '@/views/pages/public/template/components/base/Footer';
import Content from '@/views/pages/public/home/Content';
import { useRoute } from 'vue-router';
import { useAlertStore } from "@/stores";
import { onMounted, reactive } from 'vue';
import { getResponseError, prepareQuery } from "@/helpers/api";
import ModelService from '@/services/ModelService';


export default {
  name: 'DefaultLayout',
  components: { BaseNavbar, Content, BaseFooter },
  setup() {
    const service = new ModelService;
    const alertStore = useAlertStore();
    const route = useRoute();
    const currentRoute = route.path;


    // Variables reactivas
    const menus = reactive({
      total: 0,
      data: []
    });
    const page = reactive({
      sections: []
    });

    //metodos
    function fetchPage() {
      //TODO colocar pagina desde base de datos por defecto. Página home desde DB
      let page_id = typeof route.params.id != 'undefined' ? route.params.id : 1;
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
        .find(page_id, 'page/showpage')
        .then((response) => {
          page.sections = response.data.page.sections ?? [];
        })
        .catch((error) => {
          alertStore.error(getResponseError(error));
          console.log(error);

        });
    }

    onMounted(() => {
      fetchPage();
    });

    //obtener config desde el backend TODO

    return {
      menus,
      page
    }
  }
}
</script>

<style>
.cover-gradient {
  background: linear-gradient(169.4deg,
      rgba(57, 132, 244, 0.04) -6.01%,
      rgba(12, 211, 255, 0.04) 36.87%,
      rgba(47, 124, 240, 0.04) 78.04%,
      rgba(14, 101, 232, 0.04) 103.77%);
}

.cover-gradient-2 {
  background: linear-gradient(169.4deg,
      rgba(57, 132, 244, 0.1) -6.01%,
      rgba(12, 211, 255, 0.1) 36.87%,
      rgba(47, 124, 240, 0.1) 78.04%,
      rgba(14, 101, 232, 0.1) 103.77%);
}

.bg-blue-gradient,
.text-gradient {
  background: linear-gradient(136.91deg, #468ef9 -12.5%, #0c66ee 107.5%);
}

.text-gradient {
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.slide-enter-active {
  -moz-transition-duration: 0.3s;
  -webkit-transition-duration: 0.3s;
  -o-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -moz-transition-timing-function: ease-in;
  -webkit-transition-timing-function: ease-in;
  -o-transition-timing-function: ease-in;
  transition-timing-function: ease-in;
}

.slide-leave-active {
  -moz-transition-duration: 0.3s;
  -webkit-transition-duration: 0.3s;
  -o-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to,
.slide-leave {
  max-height: 100px;
  overflow: hidden;
}

.slide-enter,
.slide-leave-to {
  overflow: hidden;
  max-height: 0;
}
</style>