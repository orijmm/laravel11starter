<template>
  <nav id="navbar" class="relative z-10 w-full text-neutral-800">
    <div class="flex flex-col max-w-screen-xl px-8 mx-auto lg:items-center lg:justify-between lg:flex-row py-4">
      <div class="flex flex-col lg:flex-row items-center space-x-4 xl:space-x-8">
        <div class="w-full flex flex-row items-center justify-between py-6">
          <router-link to="/">
            <img src="@/views/pages/public/template/assets/img/logo/nefa.svg" class="w-24 xl:w-28" alt="Nefa Logo" />
          </router-link>
          <button class="rounded-lg lg:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
            <Segment v-if="!open" :size="24" />
            <Close v-else :size="24" />
          </button>
        </div>
        <ul :class="[open ? 'flex' : 'hidden lg:flex']"
          class="w-full h-auto flex flex-col flex-grow lg:items-center pb-4 lg:pb-0 lg:justify-end lg:flex-row origin-top duration-300 xl:space-x-2 space-y-3 lg:space-y-0">
          <NavLink :dataLink="menus.data" />
        </ul>
      </div>
      <div :class="[open ? 'flex' : 'hidden lg:flex']" class="space-x-3">
        <BaseButton class="px-8 xl:px-10 py-3 mt-2 bg-inherit text-gradient border border-[#0c66ee]">
          <a href="/login">Login</a>
        </BaseButton>
        <BaseButton class="px-8 xl:px-10 py-3 mt-2 bg-gradient-to-r from-[#468ef9] to-[#0c66ee] text-white">
          <a href="/register">Register</a>
        </BaseButton>
      </div>
    </div>
  </nav>
</template>
<script>
import NavLink from '@/views/pages/public/template/components/NavLink';
import { ref } from 'vue';
import BaseButton from '@/views/pages/public/template/components/base/Button';

export default {
  name: 'BaseNavbar',
  components: { NavLink, BaseButton },
  props: {
    menus: {
      type: Object,
      required: true,
      default: {},
    },
  },
  setup() {
    const open = ref(false);

    return {
      open
    }
  }
}
</script>
