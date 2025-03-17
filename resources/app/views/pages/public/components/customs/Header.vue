<template>
  <header class="wrapper">
    <nav aria-label="menu-top" :class="`navbar navbar-expand-lg center-nav transparent position-absolute px-md-10 px-xxl-0 ${addClass2 ? 'fixed navbar-clone' : ''
      } ${addClass
        ? 'navbar-clone navbar-stick navbar-light'
        : ' navbar-unstick navbar-dark'
      } `">
      <div class="container flex-lg-row flex-nowrap align-items-center">
        <div class="navbar-brand w-100">
          <router-link to="/">
            <img class="logo-light" src="/assets/img/logo-light.png" srcset="/assets/img/logo-light@2x.png 2x"
              alt="logos-light" />
          </router-link>
        </div>
        <div id="ofCanvasBody" class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
          <div class="offcanvas-header d-lg-none">
            <h3 class="text-white fs-30 mb-0">Sandbox</h3>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"
              @click="menuClose"></button>
          </div>
          <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">
            <ul class="navbar-nav">
              <Navbar :menus="menus" />
            </ul>
            <!-- /.navbar-nav -->
            <div class="offcanvas-footer d-lg-none">
              <div>
                <a href="mailto:first.last@email.com" class="link-inverse">info@email.com</a>
                <br />
                00 (123) 456 78 90 <br />
                <nav class="nav social social-white mt-4">
                  <Socials />
                </nav>
                <!-- /.social -->
              </div>
            </div>
            <!-- /.offcanvas-footer -->
          </div>
          <!-- /.offcanvas-body -->
        </div>
        <!-- /.navbar-collapse -->
        <div class="navbar-other w-100 d-flex ms-auto">
          <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-search"><i
                  class="uil uil-search"></i></a>
            </li>
            <li class="nav-item d-lg-none">
              <button @click="menuOpen" class="hamburger offcanvas-nav-btn">
                <span></span>
              </button>
            </li>
          </ul>
          <!-- /.navbar-nav -->
        </div>
        <!-- /.navbar-other -->
        <div id="offcanvasBackdrop" @click="menuClose" class="offcanvas-backdrop fade" style="display: none"></div>
      </div>
      <!-- /.container -->
    </nav>
    <div class="offcanvas offcanvas-top bg-light" id="offcanvas-search" data-bs-scroll="true">
      <div class="container d-flex flex-row py-6">
        <form @submit.prevent="() => { }" class="search-form w-100">
          <input type="text" class="form-control" placeholder="Type keyword and hit enter" />
        </form>
        <!-- /.search-form -->
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <!-- /.container -->
    </div>
    <!-- /.offcanvas -->
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
      menuClose
    }

  }
}
</script>
