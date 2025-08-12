<template>
    <h2 class="display-1 fs-56 p-5">
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
