<template>
    <div class="container py-15 py-md-17">
        <div class="row text-center py-4">
            <div class="col-11 col-lg-10 col-xxl-9 mx-auto">
                <h3 class="display-3 ls-sm mb-9 px-xl-11" data-aos="fade-up" data-aos-once="true" data-aos-delay="200">
                    {{ content[0]?.text ??
                        trans('global.phrases.hasto_add_content') }}</h3>
                <h2 class="fs-15 text-uppercase text-muted mb-3"  data-aos="fade-zoom-in" data-aos-once="true" data-aos-delay="300">
                    {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
                    <span class="underline-3 style-2 orange">{{ content[2]?.text ??
                        trans('global.phrases.hasto_add_content')
                    }}&nbsp;</span>
                    <span class="underline-3 style-2 orange">{{ content[3]?.text ??
                        trans('global.phrases.hasto_add_content')
                    }}</span>
                    {{ content[4]?.text ?? trans('global.phrases.hasto_add_content') }}
                    <span class="underline-3 style-3 green">{{ content[5]?.text ??
                        trans('global.phrases.hasto_add_content') }}</span>
                    {{ content[6]?.text ?? trans('global.phrases.hasto_add_content') }}
                </h2>
            </div>
        </div>
        <div class="row gx-lg-8 gx-xl-12 gy-8">
            <div v-for="(service, i) in services" :key="service.id" class="col-md-6 col-lg-3">
                <div class="d-flex flex-row" data-aos="fade-up" data-aos-once="true" :data-aos-delay="100 + i * 100">
                    <div>
                        <div class="icon-svg icon-svg-xs  me-5 mt-1" :class="service.icon_color_class"
                            :style="{ '-webkit-mask-image': `url(${service.icon})`, 'mask-image': `url(${service.icon})` }">
                        </div>
                    </div>
                    <div>
                        <h4 class="fs-20 ls-sm">{{ service.title }}</h4>
                        <p class="mb-0 text-justify">{{ service.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { trans } from "@/helpers/i18n";
import NoImage from '@/views/pages/private/website/components/noImage';
import imagesLoaded from "imagesloaded";
import { useRouter } from "vue-router";

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
        const router = useRouter();

        const generateUrl = (item) => {
            if (item.page_id) {
                return router.resolve({ name: "webpages", params: { id: item.page_id } }).href;
            }
            return item.url || "#";
        };
        return {
            trans,
            generateUrl
        }
    }
}
</script>