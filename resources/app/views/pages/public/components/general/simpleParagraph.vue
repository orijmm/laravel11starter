<template>
    <p class="paragraph">{{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}</p>
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
