<template>
    <div>
        <span class="text-base text-gradient font-semibold uppercase mb-4 sm:mb-2">{{ content[0]?.text ??
            trans('global.phrases.hasto_add_content') }}</span>
        <h2 class="text-3xl sm:text-4xl font-semibold mb-10 sm:mb-6">{{ content[1]?.text ??
            trans('global.phrases.hasto_add_content') }}</h2>
        <ul class="shadow-box">
            <BaseAccordion v-for="(accordion, index) in accordions" :key="index" :accordion="accordion" />
        </ul>
    </div>
</template>
<script>
import BaseAccordion from '@/views/pages/public/template/components/base/Accordion';
import { trans } from "@/helpers/i18n";
import { reactive } from 'vue';


export default {
    components: { BaseAccordion },
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

        const accordions = reactive([]);


        if (props.content.length > 2) {
            const accord = props.content.slice(2);
            for (let i = 0; i < accord.length; i += 2) {
                accordions.push({
                    title: accord[i]?.text || '',
                    description: accord[i + 1]?.text || ''
                });
            }
        }

        return {
            trans,
            accordions
        }
    }
}
</script>
