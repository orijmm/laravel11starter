<template>
    <div class="w-full">
        <img v-if="img[0] ?? false" :src="img[0]" class="w-[95%]" :alt="img" /> 
        <div v-else>{{ trans('global.phrases.hasto_add_content') }}</div>
    </div>
</template>
<script>

import { trans } from "@/helpers/i18n";

export default {
    components: {},
    props: {
        content: {
            type: [Array],
            default: [],
        },
        img: {
            type: String,
            default: [],
        }
    },
    setup(props) {

        return {
            trans
        }
    }
}
</script>
