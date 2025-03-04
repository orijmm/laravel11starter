<template>
  <footer class="max-w-screen-xl px-8 mx-auto">
    <div class="w-full border-y border-[#DDDDDD]">
      <div class="grid xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1">
        <div class="md:w-full lg:w-full w-full sm:w-1/2 xl:w-fit flex flex-col sm:flex-row sm:px-6 py-6 sm:py-12 sm:space-x-10 sm:border-r-0 border-[#DDDDDD]">
          <div class="mb-6 sm:mb-0">
            <router-link to="/">
              <img v-if="menus.logo" :src="menus.logo" class="w-14 xl:w-20" alt="Logo" />
              <img v-else src="@/views/pages/public/template/assets/img/logo/nefa.svg" class="w-24 xl:w-28"
                alt="Nefa Logo" />
            </router-link>
          </div>
          <div>
            <h5 class="text-sm font-medium text-[#666666] mb-3 focus:outline-none focus:shadow-outline">{{ menus.webdata.name_company }}</h5>
            <ul>
              <li class="text-sm text-[#666666] my-1 focus:outline-none focus:shadow-outline">{{ menus.webdata.phone }}</li>
              <li class="text-sm text-[#666666] my-1 focus:outline-none focus:shadow-outline">{{ menus.webdata.email }}</li>
              <li class="text-sm text-[#666666] my-1 focus:outline-none focus:shadow-outline">{{ menus.webdata.address }}</li>
            </ul>
          </div>
        </div>
        
        <div class="md:w-full md:border-t lg:w-full w-full sm:w-1/2 xl:w-fit sm:px-16 py-6 sm:py-12 border-t sm:border-t-0 sm:border-r-0 border-[#DDDDDD]">
          <h5 class="text-sm font-medium text-[#666666] focus:outline-none focus:shadow-outline">Más</h5>

        </div>
        <div
          class="md:w-full md:border-t lg:w-full sm:px-10 py-6 sm:py-12 w-full sm:w-1/2 xl:w-[22rem] space-y-4 sm:border-t border-[#DDDDDD]">
          <h5 class="text-sm font-medium text-[#666666] focus:outline-none focus:shadow-outline">{{ trans('global.pages.newsletter') }}</h5>
          <p class="text-sm text-[#666666] focus:outline-none focus:shadow-outline">
            {{ trans('global.phrases.newsletter_text') }}
          </p>
          <div class="flex items-center space-x-2">
            <input type="text"
              class="w-full px-2 py-4 sm:py-3 rounded-lg sm:rounded-md text-sm focus:outline-none border border-[#AAAAAA] placeholder-[#888]"
              :placeholder="trans('users.labels.addemail')" />
            <button
              class="bg-blue-gradient px-4 py-4 sm:py-3 rounded-md text-white hover:shadow-md transition duration-300">
              <ArrowRight :size="20" />
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="py-8 sm:py-4 text-center text-xs text-[#666666] hover:text-gray-900">
      &copy; Copyright {{ new Date().getFullYear() }} {{ menus.webdata.name_company }}. All rights reserved.
    </div>
  </footer>
</template>
<script>

import Link from '@/views/pages/public/template/components/Link';
import { trans } from "@/helpers/i18n";

export default {
  name: 'BaseFooter',
  components: { Link },
  props: {
    menus: {
      type: Object,
      required: true,
      default: {},
    },
  },
  setup() {
        return {
            trans
        };
    },
}
</script>
