<template>
    <!-- <p class="text-navy p-4" v-html="content[0]?.text"></p> -->
    <p class="text-navy p-4" v-html="content[0]?.text.replace(/\n/g, '<br>')"></p>
</template>
<script>

import { trans } from "@/helpers/i18n";

export default {
    components: {},
    //colocar en el div: {{ content[0].text }} ó {{ content[0].img }} por cada palabra o contenido
    props: {
        content: {
            type: [Array],
            default: [],
        },
    },
    setup(props) {

        return {
            trans
        }
    }
}
</script>
