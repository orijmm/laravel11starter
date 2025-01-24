<template>
    <div
        class="bg-gray-200 border-1 border-gray-200 rounded w-full p-2 size-40 grid content-center justify-items-center">
        {{ trans('global.phrases.hasto_add_img') }}</div>
</template>

<script>
import { defineComponent } from "vue";
import { trans } from "@/helpers/i18n";

export default defineComponent({
    setup() {
        return {
            trans,
        }
    }
})
</script>