<template>
    <div class="row gx-3 gy-10 gy-lg-0 align-items-center">
        <div class="col-lg-6 order-lg-2">
            <figure>
                <img class="w-auto" src="/assets/img/illustrations/3d5.png" alt="servocpohot" />
            </figure>
        </div>
        <div class="col-lg-6 me-auto">
            <h3 class="display-4 mb-5 pe-xxl-5">
                {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
            </h3>
            <p class="mb-6">
                {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
            </p>
            <div class="row align-items-center counter-wrapper gy-6">
                <div v-for="(service, i) in services" :key="service.id" class="col-md-4 text-center">
                    <div class="d-flex justify-content-center">
                        <div class="icon-svg icon-svg-xs mt-1 mask-center-contain" :class="service.icon_color_class"
                            :style="{
                                WebkitMaskImage: `url(${service.icon})`,
                                maskImage: `url(${service.icon})`
                            }"></div>
                    </div>
                    <h6 class="fs-17 mb-1 text-secondary">{{ service.description }}</h6>
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