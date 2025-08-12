<template>
    <div class="btn btn-sky rounded-pill">
        {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
    </div>
</template>
<script>

import { trans } from "@/helpers/i18n";

export default {
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
