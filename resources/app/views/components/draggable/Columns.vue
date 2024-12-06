<template>
    <div class="text-gray-400 bg-gray-100 p-2 rounded-lg text-center">
        draggable
    </div>
</template>

<script>
import { defineComponent, ref } from "vue";
// import { updateOrder, deleteItems } from "@/helpers/draggable";
// import Tooltip from "@/views/components/Tooltip";
// import draggable from 'vuedraggable';
// import { trans } from "@/helpers/i18n";

export default defineComponent({
    components: {},
    props: {
        columns: {
            type: Array,
            default: []
        }
    },
    setup(props) {
        // let drag = ref(false);

        // return {
        //     drag,
        //     trans,
        //     updateOrder,
        //     deleteItems
        // }
    }
})
</script>