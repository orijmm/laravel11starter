<template>
    <section class="wrapper image-wrapper-noposition bg-leftbottom bg-xs-none bg-md-none" 
    :style="{ backgroundImage: `url(${img[0] ?? '/assets/img/photos/bg38.jpg'})` }">
        <div class="row gx-3 gy-10 gy-lg-0 p-6 p-lg-14 align-items-center">
            <div class="col-lg-7 me-auto text-center">
                <h3 class="display-3 mb-5">
                    <span class="text-white">{{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
                    <span>&nbsp;{{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
                </h3>
                <div class="text-white text-justify">
                    {{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}
                </div>
                <a href="#" class="btn btn-primary rounded-pill my-3">{{ content[3]?.text ??
                    trans('global.phrases.hasto_add_content') }}</a>
                <p class="fs-lg text-white text-bold">
                    {{ content[4]?.text ?? trans('global.phrases.hasto_add_content') }}
                </p>
                <p class="fs-lg text-white text-bold">
                    {{ content[5]?.text ?? trans('global.phrases.hasto_add_content') }}
                </p>
            </div>
            <div class="col-lg-5">
            </div>
        </div>
    </section>
</template>

<script>
import { trans } from "@/helpers/i18n";
import NoImage from '@/views/pages/private/website/components/noImage';
import imagesLoaded from "imagesloaded";

export default {
    components: { NoImage, imagesLoaded },
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
        
        return {
            trans
        }
    }
}
</script>