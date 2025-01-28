<template>
    <div class="space-y-2">
        <h4 class="text-lg font-medium">{{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}</h4>
        <p class="paragraph text-sm xl:text-base">
            {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
        </p>
    </div>
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
