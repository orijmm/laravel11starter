<template>
    <div class="container p-1 p-xl-6">
        <div class="row g-6">
            <div class="col-12">
                <h1 class="text-white text-center">
                    {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
                </h1>
                <div v-if="content[1]?.text" class="text-white text-justify">{{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}</div>
                <div v-if="content[2]?.text" class="mb-5 text-white text-justify">
                    {{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { trans } from "@/helpers/i18n";
export default {
    props: {
        content: {
            type: [Array],
            default: [],
        },
        img: {
            type: String,
            default: [],
        },
        extradata: {
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