<template>
  <div v-for="menu in dataLink">
    <!-- Si no tiene parent_id que se muestre -->
    <li class="w-full" v-if="!menu.parent_id && menu.children.length == 0">
      <router-link v-if="menu.page_id" :to="generateUrl(menu)"
        class="md:px-4 py-2 text-sm bg-transparent rounded-lg text-[#666666] hover:text-gray-900 focus:outline-none focus:shadow-outline">
        {{ menu.label }}
      </router-link>
      <a v-else v-smooth-scroll
        class="md:px-4 py-2 text-sm bg-transparent rounded-lg text-[#666666] hover:text-gray-900 focus:outline-none focus:shadow-outline"
        :href="menu.url  || '#'">
        {{ menu.label }}
      </a>
    </li>
    <!-- Si tiene parent_id que se muestre -->
    <li v-if="menu.children.length > 0" class="relative group">
      <button
        class="md:px-4 py-2 text-sm bg-transparent rounded-lg text-[#666666] hover:text-gray-900 focus:outline-none focus:shadow-outline flex items-center"
        @click="dropdownToggler" @blur="dropdownToggler">
        <span>{{ menu.label }}</span>
        <ChevronUp v-if="dropdownNavbar" :size="16" />
        <ChevronDown v-else :size="16" />
      </button>
      <transition name="transform-fade-down">
        <ul v-if="dropdownNavbar"
          class="flex lg:absolute flex-col max-w-42 py-1 lg:bg-white rounded-md lg:shadow-md pl-2 lg:pl-0">
          <li v-for="childrens in menu.children">
            <button v-if="childrens.page_id" @click="navigateTo(childrens)"
              class="md:px-4 py-2 text-sm bg-transparent rounded-lg text-[#666666] hover:text-gray-900 focus:outline-none focus:shadow-outline">
              {{ childrens.label }}
            </button>
            <a v-else v-smooth-scroll
              class="md:px-4 py-2 text-sm bg-transparent rounded-lg text-[#666666] hover:text-gray-900 focus:outline-none focus:shadow-outline"
              :href="childrens.url || '#'">
              {{ childrens.label }}
            </a>
          </li>
        </ul>
      </transition>
    </li>
  </div>
</template>
<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
  props: {
    dataLink: {
      type: Array,
      required: true,
      default: []
    },
  },
  setup() {
    // Variables reactivas
    const dropdownNavbar = ref(false);
    const router = useRouter();

    const dropdownToggler = (event) => {
      if (event?.type === "blur") {
        setTimeout(() => {
          dropdownNavbar.value = false;
        }, 200); // Espera 200ms antes de cerrar el dropdown
      } else {
        dropdownNavbar.value = !dropdownNavbar.value;
      }
    }

    //obtener config desde el backend
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
      dropdownNavbar,
      dropdownToggler,
      generateUrl,
      navigateTo
    }
  }
}
</script>
