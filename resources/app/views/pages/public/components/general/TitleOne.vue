<template>
    <h2 class="text-4xl font-semibold display-1 mb-3 py-10 py-lg-17 text-center text-light">
        {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }} <span class="text-header-gradient">{{ content[1]?.text ?? '' }}</span> {{ content[2]?.text ?? '' }}
    </h2>
</template>
<script>

import { trans } from "@/helpers/i18n";

export default {
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
