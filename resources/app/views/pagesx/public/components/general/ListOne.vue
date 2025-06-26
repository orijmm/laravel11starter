<template>
    <ul class="space-y-4 sm:space-y-2">
        <LandingListItem title="Up to 3% back on purchases" />
        <LandingListItem title="Earn rewards in bitcoin or any crypto on NEFA" />
        <LandingListItem title="No annual fee" />
    </ul>
</template>
<script>

import { trans } from "@/helpers/i18n";
import LandingListItem from '@/views/pages/public/template/components/landing/ListItem';

export default {
    components: { LandingListItem },
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
