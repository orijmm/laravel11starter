<template>
  <div v-for="(menu, i) in menus.data" :key="`divli-${i}`">
    <!-- |||||||| Si es un menu sin padre y sin hijos |||||| -->
    <li class="nav-item" v-if="!menu.parent_id && menu.children_recursive.length == 0">
      <!-- Si tiene página asignada router-link -->
      <router-link v-if="menu.page_id" :class="`${isActiveMenu([], menu.page_id) ? 'active nav-link' : 'nav-link'
        }`" :to="generateUrl(menu)">{{ menu.label }}
      </router-link>
      <!-- Si no tiene página pero si url/seccion asignada -->
      <a v-else-if="!menu.page_id && menu.url && isDesktop && !route.params.id" v-smooth-scroll data-aos="flip-down"
        data-aos-delay="150" class="nav-link" :href="menu.url || '#'">
        {{ menu.label }}
      </a>
      <!-- Si no tiene página ni url/seccion asignada solo imprima sin link -->
      <div v-else class="nav-link">{{ menu.label }}</div>
    </li>
    <!-- |||||||| Si es un menu sin padre y con  hijos |||||| -->
    <li v-if="!menu.parent_id && menu.children_recursive.length > 0" class="nav-item dropdown">
      <a :class="`nav-link dropdown-toggle ${isActiveMenu(menu) ? 'active' : ''}`" href="#" data-bs-toggle="dropdown"
        data-bs-auto-close="outside" aria-expanded="false">{{ menu.label }}
      </a>
      <!-- Imprimir hijos,  Solo aceptan páginas no secciones ni url -->
      <NavbarItem v-if="menu.children_recursive.length" :menus="menu.children_recursive"
        :is-desktop="isDesktop" :is-active-menu="isActiveMenu" :generate-url="generateUrl" />
    </li>
  </div>
</template>

<script>
import { ref } from "vue";
import { trans } from "@/helpers/i18n";
import { useRoute, useRouter } from "vue-router";

export default {
  props: {
    menus: {
      type: Object,
      required: true,
      default: {},
    },
  },
  setup(props) {
    const isDesktop = window.innerWidth > 1024;
    const open = ref(false);
    const route = useRoute();
    const router = useRouter();
    const isActiveMenu = (menu) => {
      let isActive = false;
      const currentPageId = route.params.id || null; // Extrae el pageId de la URL si existe
      if (Array.isArray(menu) && menu.length) {
        menu.forEach((elm) => {
          if (elm.page_id && elm.page_id == currentPageId) {
            isActive = true;
          }
          if (elm.children_recursive) {
            elm.children_recursive.forEach((elm2) => {
              if (elm2.page_id && elm2.page_id == currentPageId) {
                isActive = true;
              }
            });
          }
        });
      }

      return isActive;
    };

    const generateUrl = (menu) => {
      if (menu.page.slug) {
        return router.resolve({ name: "webpages", params: { slug: menu.page.slug } }).href;
      }
      return menu.url || "#";
    };

    // const navigateTo = (menu) => {
    //   if (menu.page_id) {
    //     router.push(generateUrl(menu));
    //   }
    // };

    return {
      trans,
      open,
      isActiveMenu,
      generateUrl,
      // navigateTo,
      isDesktop,
      route
    }
  }
}
</script>
