<template>
    <div class="text-gray-400 bg-gray-100 p-1 rounded-lg text-center">
        componentes
    </div>
</template>

<script>
import { defineComponent} from "vue";
import { trans } from "@/helpers/i18n";


export default defineComponent({
    components: {},
    props: {
        // columns: {
        //     type: Array,
        //     default: () => []
        // },
    },
    setup(props) {
        // let drag = ref(false);

        // function onDeleteItems(cols, index) {
            
        // }

        return {
            trans,
        }
    }
})
</script>