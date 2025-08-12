<template>
    <div class="row gx-3 gy-10 gy-lg-0 py-5 py-lg-10 align-items-center">
        <div class="col-12 me-auto text-center">
            <h2 class="display-1 fs-56 mb-5 ls-xs pe-xl-5 pe-xxl-0  text-center">
                <span v-if="content[0]?.text" class="text-navy">{{ content[0]?.text ??
                    trans('global.phrases.hasto_add_content') }}</span>
                <span v-if="content[1]?.text">&nbsp;{{ content[1]?.text ?? trans('global.phrases.hasto_add_content')
                }}</span>
            </h2>
            <p class="lead fs-23 lh-sm mb-7 pe-lg-5 pe-xl-5 pe-xxl-0 text-center">
                <span class="text-red" v-if="content[2]?.text">{{ content[2]?.text ??
                    trans('global.phrases.hasto_add_content')
                    }}</span>
                <span class="text-navy" v-if="content[3]?.text">&nbsp;{{ content[3]?.text ??
                    trans('global.phrases.hasto_add_content')
                    }}</span>
                <span class="text-red" v-if="content[4]?.text">&nbsp;{{ content[4]?.text ??
                    trans('global.phrases.hasto_add_content')
                    }}</span>
                <span class="text-navy" v-if="content[5]?.text">{{ content[5]?.text ??
                    trans('global.phrases.hasto_add_content')
                    }}</span>
            </p>
            <div class="row align-items-center justify-content-center text-center">
                <div v-for="(service, i) in services" :key="service.id" class="col-md-4">
                    <div class="d-flex justify-content-center">
                        <div class="icon-svg icon-svg-xxl mt-1 mask-center-contain" :class="service.icon_color_class"
                            :style="{
                                WebkitMaskImage: `url(${service.icon})`,
                                maskImage: `url(${service.icon})`
                            }"></div>
                    </div>
                    <div class="fs-22 text-bold my-3 text-navy">{{ service.description }}</div>
                </div>
            </div>
        </div>
    </div>
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