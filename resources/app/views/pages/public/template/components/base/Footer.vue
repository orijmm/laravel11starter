<template>
  <footer class="max-w-screen-xl px-8 mx-auto">
    <div class="py-8 sm:py-4 text-center text-xs text-[#666666] hover:text-gray-900">
      &copy; Copyright {{ new Date().getFullYear() }} {{ menus.webdata.name_company }}. All rights reserved.
    </div>
  </footer>
</template>
<script>

import { trans } from "@/helpers/i18n";
import Icon from "@/views/components/icons/Icon";

export default {
  name: 'BaseFooter',
  components: { Icon },
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
