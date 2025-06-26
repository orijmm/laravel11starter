<template>
    <div class="">
        <img v-if="img[0] ?? false" :src="img[0]" class="w-[95%]" :alt="img" />
        <NoImage v-else />
    </div>
</template>
<script>

import { trans } from "@/helpers/i18n";
import NoImage from '@/views/pages/private/website/components/noImage';

export default {
    components: { NoImage },
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
