<template>
  <div class="w-100 order-1 order-lg-0 d-lg-flex offcanvas-body">
    <ul v-if="menus.data" class="navbar-nav ms-lg-auto">
      <div v-if="route.params.slug" class="d-flex align-items-center">
        <li class="nav-item">
        <router-link to="/" class="text-light">
            {{ trans('global.menu.home') }}
          </router-link>
      </li>
        </div>
      <div v-for="menu in menus.data">
        <!-- |||||||| Si es un menu sin padre y sin hijos |||||| -->
        <li class="nav-item" v-if="!menu.parent_id && menu.children_recursive.length == 0">
          <!-- Si tiene página asignada router-link -->
          <router-link v-if="menu.page_id && menu.page && menu.page.slug" :class="`${isActiveMenu(menu) ? 'active nav-link' : 'nav-link'
            }`" :to="generateUrl(menu)">{{ menu.label }}
          </router-link>
          <!-- Si no tiene página pero si url/seccion asignada -->
          <a v-else-if="!menu.page_id && menu.url && isDesktop && !route.params.slug" v-smooth-scroll data-aos="flip-down" data-aos-delay="150" class="nav-link"
            :href="menu.url || '#'">
            {{ menu.label }}
          </a>
          <!-- Si no tiene página ni url/seccion asignada solo imprima sin link -->
          <div v-else-if="!route.params.slug" class="nav-link">{{ menu.label }}</div>
        </li>
        <!-- |||||||| Si es un menu sin padre y con  hijos |||||| -->
        <li v-if="!menu.parent_id && menu.children_recursive.length > 0" class="nav-item dropdown">
          <a :class="`nav-link dropdown-toggle ${isActiveMenu(menus.data) ? 'active' : ''}`" href="#"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">{{ menu.label }}
          </a>
          <!-- Imprimir hijos,  Solo aceptan páginas no secciones ni url -->
          <ul class="dropdown-menu" v-if="menu.children_recursive && menu.children_recursive.length">
            <li v-for="item in menu.children_recursive" :key="item.id" :class="`${item.children_recursive && item.children_recursive.length > 0 ? 'dropdown dropdown-submenu dropend' : 'nav-item'
              }`">
              <a :class="`dropdown-item dropdown-toggle  ${isActiveMenu(item.children_recursive)
                ? 'active'
                : ''
                }`" v-if="item.children_recursive && item.children_recursive.length > 0" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"
                href="#">{{ item.label }}</a>
                
              <router-link v-else-if="item.page_id && item.page && item.page.slug" :class="`dropdown-item   ${isActiveMenu(item) ? 'active' : ''
                }`" :to="generateUrl(item)">{{ item.label }}
              </router-link>
              <span v-else class="dropdown-item">{{ item.label }}</span>
            </li>
          </ul>
        </li>
      </div>
    </ul>
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
    const isDesktop = window.innerWidth > 768;
    const open = ref(false);
    const route = useRoute();
    const router = useRouter();
    const isActiveMenu = (menu, page_id) => {
      let isActive = false;
      const currentSlug = route.params.slug || null; // Extrae el slug de la URL si existe
      if (Array.isArray(menu)) {
        menu.forEach((elm) => {
          if (elm.page && elm.page.slug && elm.page.slug == currentSlug) {
            isActive = true;
          }
          if (elm.children_recursive) {
            elm.children_recursive.forEach((elm2) => {
              if (elm2.page && elm2.page.slug && elm2.page.slug == currentSlug) {
                isActive = true;
              }
            });
          }
        });
      } else {
        // Para items individuales, necesita tener la página cargada
        if (menu && menu.page && menu.page.slug) {
          return menu.page.slug == currentSlug;
        }
        return false;
      }

      return isActive;
    };

    const generateUrl = (menu) => {
      if (menu.page_id && menu.page && menu.page.slug) {
        return { name: "webpages", params: { slug: menu.page.slug } };
      }
      return "#";
    };

    const navigateTo = (menu) => {
      if (menu.page_id) {
        router.push(generateUrl(menu));
      }
    };

    return {
      trans,
      open,
      isActiveMenu,
      generateUrl,
      navigateTo,
      isDesktop,
      route
    }
  }
}
</script>
