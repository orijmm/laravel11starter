<template>
    <!-- <section class="hero-background"
        style="background-image: url(/assets/img/map.png)"> -->
        <div class="container py-0 py-md-17">
            <div class="row">
                <div class="col-lg-6 col-xl-5 mx-auto">
                    <h2 class="display-4 mb-3 text-center">{{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}</h2>
                    <!-- <p class="lead mb-5 px-md-16 px-lg-3">
                        {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
                    </p>
                    <router-link to="/" class="btn btn-primary rounded-pill">{{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}</router-link> -->
                </div>
            </div>
        </div>
    <!-- </section> -->
</template>

<script>
import { trans } from "@/helpers/i18n";

export default {
    props: {
        content: {
            type: [Array],
            default: [],
        },
        services: {
            type: [Array],
            default: [],
        },
        img: {
            type: String,
            default: [],
        }
    },
    setup(props) {
        const checklistItems = [];
        return {
            trans,
            checklistItems
        }
    }
}
</script>
