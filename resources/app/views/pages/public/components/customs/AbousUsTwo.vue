<template>
    <div class="row gy-10 gy-sm-13 gx-md-8 gx-xl-12 align-items-start mb-10 mb-md-12 p-5">
        <div v-for="(service, i) in services.slice(2)" :key="service.id" class="col-lg-6">
            <div class="d-flex flex-row">
                <div>
                    <div class="icon-svg icon-svg-xs  me-5 mt-1" :class="service.icon_color_class"
                        :style="{ '-webkit-mask-image': `url(${service.icon})`, 'mask-image': `url(${service.icon})` }">
                    </div>
                </div>
                <div>
                    <h4 class="fs-20 ls-sm">{{ service.title }}</h4>
                    <p class="mb-2 text-justify">{{ service.description }}</p>
                </div>
            </div>
        </div>
        <div v-for="(service, i) in services.slice(0,2)" :key="service.id" class="col-lg-3">
            <div class="d-flex flex-row">
                <div>
                    <div class="icon-svg icon-svg-xs  me-5 mt-1" :class="service.icon_color_class"
                        :style="{ '-webkit-mask-image': `url(${service.icon})`, 'mask-image': `url(${service.icon})` }">
                    </div>
                </div>
                <div>
                    <h4 class="fs-20 ls-sm">{{ service.title }}</h4>
                    <p class="mb-2 text-justify">{{ service.description }}</p>
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
