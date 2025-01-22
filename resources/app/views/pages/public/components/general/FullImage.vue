<template>
    <div class="w-full">
        <img v-if="img" :src="img" class="w-[95%]" :alt="img" /> 
        <div v-else>{{ trans('global.phrases.hasto_add_content') }}</div>
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
