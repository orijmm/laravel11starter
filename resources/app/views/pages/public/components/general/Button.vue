<template>
    <BaseButton class="w-full sm:max-w-[240px] px-10 py-4 bg-inherit text-gradient border border-[#0c66ee] text-base">
        {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
    </BaseButton>
</template>
<script>

import { trans } from "@/helpers/i18n";
import BaseButton from '@/views/pages/public/template/components/base/Button';

export default {
    components: { BaseButton },
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
