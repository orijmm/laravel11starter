<template>
    <div class="w-full px-6 sm:px-0 py-16 flex flex-col items-center justify-center space-y-4 text-center">
        <h3 data-aos="flip-down" class="text-2xl text-neutral-800 font-semibold">{{ content[0]?.text ??
            trans('global.phrases.hasto_add_content') }}</h3>
        <p data-aos="flip-down" class="paragraph">{{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
        </p>
        <div v-if="img.length" data-aos="fade-up" class="flex flex-wrap items-center justify-center">
            <LandingPartnerImage v-for="image in img" :key="image" :img="image" />
        </div>
        <div v-else data-aos="fade-up" class="flex flex-wrap items-center justify-center">
            <NoImage />
        </div>
    </div>
</template>
<script>
import LandingPartnerImage from '@/views/pages/public/template/components/landing/PartnerImage';
import { trans } from "@/helpers/i18n";
import NoImage from '@/views/pages/private/website/components/noImage';


export default {
    components: { LandingPartnerImage, NoImage },
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
