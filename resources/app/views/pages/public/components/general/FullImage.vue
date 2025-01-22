<template>
    <div class="w-full">
        <!-- <img src="@/views/pages/public/template/assets/img/nefa-cc.webp" class="w-[95%]" alt="" />  -->
        <img src="@/views/pages/public/template/assets/img/nefa-cc.webp" class="w-[95%]" alt="" /> 
    </div>
</template>
<script>

import { trans } from "@/helpers/i18n";

export default {
    components: {  },
    //colocar en el div: {{ content[0].text }} ó {{ content[0].img }} por cada palabra o contenido
    props: {
        content: {
            type: [Array],
            default: [],
        },
        img: {
            type: String,
            default: '',
        },
    },
    setup(props) {

        return {
            trans
        }
    }
}
</script>
