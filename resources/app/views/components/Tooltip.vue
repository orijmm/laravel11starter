<template>
  <div class="group relative inline-block">
    <!-- El slot para el contenido donde se aplicará el tooltip -->
    <slot></slot>
    <div :class="[positionClasses]"
      class="bg-gray-400 absolute whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
      {{ text }}
    </div>
  </div>
</template>

<script>
import { computed, defineComponent } from "vue";

export default defineComponent({
  props: {
    text: {
      type: String,
      required: true
    },
    position: {
      type: String,
      default: 'top',
      validator: value => ['top', 'right', 'bottom', 'left'].includes(value)
    }
  },
  setup(props) {

    const positionClasses = computed(() => {
      switch (props.position) {
        case 'top':
          return 'bottom-full left-1/2 z-50 -translate-x-1/2 mb-2';
        case 'right':
          return 'left-full top-1/2 z-50 -translate-y-1/2 ml-2';
        case 'bottom':
          return 'top-full left-1/2 z-50 -translate-x-1/2 mt-2';
        case 'left':
          return 'right-full top-1/2 z-50 -translate-y-1/2 mr-2';
        default:
          return '';
      }
    });

    return {
      positionClasses
    }
  }
})
</script>