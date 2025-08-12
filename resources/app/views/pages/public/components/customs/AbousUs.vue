<template>
    <div class="row gy-10 gy-sm-13 gx-md-8 gx-xl-12 align-items-center mb-10 mb-md-12 p-5">
        <div class="col-lg-6">
            <div class="row gx-md-5 gy-5">
                <div class="col-md-6">
                    <figure class="rounded">
                        <img src="/assets/img/photos/g14.jpg" alt="imgtopi" />
                    </figure>
                </div>
                <div class="col-md-6 align-self-end">
                    <figure class="rounded">
                        <img src="/assets/img/photos/g15.jpg" alt="imgtopi2" />
                    </figure>
                </div>
                <div class="col-12">
                    <figure class="rounded mx-md-5">
                        <img src="/assets/img/photos/g16.jpg" alt="imgtopi3" />
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <h2 class="fs-15 text-uppercase text-muted mb-3">{{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}</h2>
            <h3 class="display-3 ls-sm mb-5">
                {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
            </h3>
            <p class="mb-6 text-justify">
                {{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}
                <span class="text-bold">{{ content[3]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
                {{ content[4]?.text ?? trans('global.phrases.hasto_add_content') }}
            </p>
            <div class="row align-items-center counter-wrapper gy-6 mt-4">
                <div v-for="(service, i) in services" :key="service.id" class="col-md-4 text-center">
                    <div class="d-flex justify-content-center">
                        <div class="icon-svg icon-svg-lg mt-1 mask-center-contain" :class="service.icon_color_class"
                            :style="{
                                WebkitMaskImage: `url(${service.icon})`,
                                maskImage: `url(${service.icon})`
                            }"></div>
                    </div>
                    <h4 class="fs-30 my-4 text-secondary">{{ service.title }}</h4>
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
