<template>
    <h2 class="text-4xl font-semibold">
        Introducing the <span class="text-header-gradient">NEFA</span> Credit Card
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
