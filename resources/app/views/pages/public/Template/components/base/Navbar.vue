<template>
  <div class="w-100 order-1 order-lg-0 d-lg-flex offcanvas-body">
    <ul v-if="menus.data" class="navbar-nav ms-lg-auto">
      <div v-for="menu in menus.data">
        <li class="nav-item" v-if="!menu.parent_id && menu.children.length == 0">
          <router-link v-if="menu.page_id" :class="`${isActiveMenu([], menu.page_id) ? 'active' : ''
            }`" :to="generateUrl(menu)">{{ menu.label }}
          </router-link>
          <a v-else-if="!menu.page_id && menu.url" v-smooth-scroll data-aos="flip-down" data-aos-delay="150" class="nav-link"
            :href="menu.url || '#'">
            {{ menu.label }}
          </a>
          <div v-else="!menu.page_id" class="nav-link">{{ menu.label }}</div>
        </li>
        <li v-if="!menu.parent_id && menu.children.length > 0" class="nav-item dropdown">
          <a :class="`nav-link dropdown-toggle ${isActiveMenu(menus.data) ? 'active' : ''}`" href="#"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">{{ menu.label }}
          </a>
          <ul class="dropdown-menu" v-if="menu.children && menu.children.length">
            <li v-for="item in menu.children" :key="item.id" :class="`${menu.children ? 'dropdown dropdown-submenu dropend' : 'nav-item'
              }`">
              <a :class="`dropdown-item dropdown-toggle  ${isActiveMenu(item.children ? item.children : [], item.page_id)
                ? 'active'
                : ''
                }`" v-if="item.children" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"
                href="#">{{ item.label }}</a>
              <router-link v-else :class="`dropdown-item   ${isActiveMenu([], item.page_id) ? 'active' : ''
                }`" :to="generateUrl(item)">{{ item.label }}
              </router-link>
              <!-- <ul class="dropdown-menu" v-if="item.children && item.children.length">
                <li class="nav-item" v-for="submenuItem in item.children" :key="submenuItem.id">
                  <router-link :class="`dropdown-item ${isActiveMenu([], submenuItem.page_id) ? 'active' : ''
                    }`" :to="submenuItem.page_id">{{ submenuItem.label }}
                  </router-link>
                  {{ submenuItem.label }}
                </li>
              </ul> -->
            </li>
          </ul>
        </li>
      </div>
    </ul>
    <!-- /.navbar-nav -->
  </div>
</template>

<script>
import { ref } from "vue";
import {
  blockItems,
  blogItems,
  demos,
  elements,
  pages,
  projects,
  singleProjects,
  styleGuideItems,
  usage,
} from "../home/data/menu";

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
    // const authStore = useAuthStore();
    const open = ref(false);
    const route = useRoute();
    const router = useRouter();

    const isActiveMenu = (menu, page_id) => {
      let isActive = false;
      const currentPageId = route.params.page || null; // Extrae el pageId de la URL si existe

      if (Array.isArray(menu)) {
        menu.forEach((elm) => {
          if (elm.page_id && elm.page_id == currentPageId) {
            isActive = true;
          }
          if (elm.children) {
            elm.children.forEach((elm2) => {
              if (elm2.page_id && elm2.page_id == currentPageId) {
                isActive = true;
              }
            });
          }
        });
      } else {
        return page_id == currentPageId;
      }

      return isActive;
    };

    const generateUrl = (menu) => {
      if (menu.page_id) {
        return router.resolve({ name: "webpages", params: { id: menu.page_id } }).href;
      }
      return menu.url || "#";
    };

    const navigateTo = (menu) => {
      if (menu.page_id) {
        router.push(generateUrl(menu));
      }
    };

    return {
      open,
      isActiveMenu,
      blockItems,
      blogItems,
      demos,
      elements,
      pages,
      projects,
      singleProjects,
      styleGuideItems,
      usage,
      generateUrl,
      navigateTo
    }
  }
}
</script>
