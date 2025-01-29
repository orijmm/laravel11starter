<template>
  <div v-for="menu in dataLink">
    <!-- Si no tiene parent_id que se muestre -->
    <li class="w-full" v-if="!menu.parent_id && menu.children.length == 0">
      <a class="md:px-4 py-2 text-sm bg-transparent rounded-lg text-[#666666] hover:text-gray-900 focus:outline-none focus:shadow-outline"
        :href="menu.url">
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
            <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">{{ childrens.label }}</a>
          </li>
        </ul>
      </transition>
    </li>
  </div>
</template>
<script>
import { ref } from 'vue';

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

    const dropdownToggler = () => {
      dropdownNavbar.value = !dropdownNavbar.value;
    }

    //obtener config desde el backend

    return {
      dropdownNavbar,
      dropdownToggler
    }
  }
}
</script>
