<template>
  <li class="nav-item dropdown dropdown-mega">
    <a
      :class="`nav-link dropdown-toggle ${isActiveMenu(demos) ? 'active' : ''}`"
      href="#"
      data-bs-toggle="dropdown"
      data-bs-auto-close="outside"
      aria-expanded="false"
      >Demos</a
    >
    <ul class="dropdown-menu mega-menu mega-menu-dark mega-menu-img">
      <li class="mega-menu-content mega-menu-scroll">
        <ul
          class="row row-cols-1 row-cols-lg-6 gx-0 gx-lg-4 gy-lg-2 list-unstyled"
        >
          <li class="col" v-for="demo in demos" :key="demo.id">
            <router-link
              :class="`dropdown-item ${
                isActiveMenu([], demo.route) ? 'active' : ''
              }`"
              :to="demo.route"
            >
              <figure class="rounded lift d-none d-lg-block">
                <img
                  :src="demo.imageSrc"
                  :srcset="demo.imageSrcSet"
                  alt="image"
                />
              </figure>
              <span class="d-lg-none">{{ demo.name }}</span>
            </router-link>
          </li>
        </ul>
        <!--/.row -->
        <span class="d-none d-lg-flex"
          ><i class="uil uil-direction"></i
          ><strong>Scroll to view more</strong></span
        >
      </li>
      <!--/.mega-menu-content-->
    </ul>
    <!--/.dropdown-menu -->
  </li>
</template>

<script setup>
import { useRoute } from "vue-router";
import {
  demos,
  pages,
  projects,
  singleProjects,
  blogItems,
  blockItems,
  usage,
  styleGuideItems,
  elements,
} from "./../../../components/customs/data/menu.js";

const route = useRoute();

const pathName = route.path;

const isActiveMenu = (menu, menuItem) => {
  let isActive = false;

  if (typeof menu != "string" && menu.length) {
    menu?.forEach((elm) => {
      if (elm.route == pathName) {
        isActive = true;
      }
      if (elm.submenu) {
        elm.submenu.forEach((elm2) => {
          if (elm2.route == pathName) {
            isActive = true;
          }
        });
      }
    });
  } else {
    return menuItem == pathName;
  }

  return isActive;
};
</script>

<style lang="scss" scoped></style>
