<template>
  <header class="wrapper bg-light">
    <nav :class="`navbar navbar-expand-lg classic transparent position-absolute navbar-light ${addClass2 ? 'fixed navbar-clone' : ''
      } ${addClass ? 'navbar-clone navbar-stick' : ' navbar-unstick'} `">
      <div class="container flex-lg-row flex-nowrap align-items-center">
        <div class="navbar-brand w-100">
          <router-link to="/">
            <img v-if="menus.logo" width="250px" :class="addClass ? 'logo-dark m-1' : 'logo-light m-1'"
              :src="addClass ? menus.logo : (menus.logo2 ?? menus.logo)" alt="logos-light" />
            <div v-else>{{ menus.webdata.name_company ?? '' }}</div>
          </router-link>
        </div>
        <div id="ofCanvasBody" class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
          <div class="offcanvas-header d-lg-none">
            <h3 class="text-white fs-30 mb-0">{{ menus.webdata.name_company ?? '' }}</h3>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"
              @click="menuClose"></button>
          </div>
          <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">
            <ul v-if="menus.data" class="navbar-nav">
              <Navbar :menus="menus" />
            </ul>
            <div class="offcanvas-footer d-lg-none">
              <div>
                <a :href="`mailto:${menus.webdata.email}`" class="link-inverse">{{ menus.webdata.email }}</a>
                <br />
                {{ menus.webdata.phone }}<br />
                <nav class="nav social social-white mt-4">
                  <Socials :webdata="menus.webdata" />
                </nav>
              </div>
            </div>
          </div>
        </div>
        <div class="navbar-other ms-lg-4">
          <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item d-lg-none">
              <button @click="menuOpen" class="hamburger offcanvas-nav-btn">
                <span></span>
              </button>
            </li>
          </ul>
        </div>
        <div id="offcanvasBackdrop" @click="menuClose" class="offcanvas-backdrop fade" style="display: none"></div>
      </div>
    </nav>
    <div class="offcanvas offcanvas-top bg-light" id="offcanvas-search" data-bs-scroll="true">
      <div class="container d-flex flex-row py-6">
        <form @submit.prevent="() => { }" class="search-form w-100">
          <input type="text" class="form-control" placeholder="Type keyword and hit enter" />
        </form>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
    </div>
  </header>
</template>

<script>
import { ref, onMounted, onBeforeUnmount } from 'vue';
export default {
  props: {
    menus: {
      type: Object,
      required: true,
      default: {},
    },
  },
  setup() {
    const menuOpen = () => {
      document.getElementById("ofCanvasBody").classList.toggle("show");
      document.getElementById("offcanvasBackdrop").style.display = "block";
      document.getElementById("offcanvasBackdrop").classList.toggle("show");
    };

    const menuClose = () => {
      document.getElementById("ofCanvasBody").classList.toggle("show");
      document.getElementById("offcanvasBackdrop").classList.toggle("show");
      setTimeout(() => {
        document.getElementById("offcanvasBackdrop").style.display = "none";
      }, 300);
    };

    const addClass = ref(false);
    const addClass2 = ref(false);

    const handleScroll = () => {
      addClass2.value = window.scrollY >= 200;
      addClass.value = window.scrollY >= 300;
    };

    onMounted(() => {
      window.addEventListener("scroll", handleScroll);
    });

    onBeforeUnmount(() => {
      window.removeEventListener("scroll", handleScroll);
    });

    return {
      menuOpen,
      menuClose,
      addClass2,
      addClass
    }

  }
}
</script>
