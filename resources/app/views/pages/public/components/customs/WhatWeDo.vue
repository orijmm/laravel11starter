<template>
    <div class="container py-9 py-md-11">
        <div class="row text-center py-4">
            <div class="col-11 col-lg-10 col-xxl-9 mx-auto">
                <h2 class="fs-15 text-uppercase text-muted mb-3">
                    {{ content[0]?.text ??
                        trans('global.phrases.hasto_add_content') }}</h2>
                <h5 class="display-5 mb-5 text-navy">
                    <span v-if="content[1]?.text" class="text-bold">{{ content[1]?.text ??
                        trans('global.phrases.hasto_add_content') }}</span>
                    <span v-if="content[2]?.text">&nbsp;{{ content[2]?.text ??
                        trans('global.phrases.hasto_add_content')
                        }}</span>
                    <span v-if="content[3]?.text" class="text-bold">&nbsp;{{ content[3]?.text ??
                        trans('global.phrases.hasto_add_content')
                        }}</span>
                    <span v-if="content[4]?.text">&nbsp;{{ content[4]?.text ??
                        trans('global.phrases.hasto_add_content') }}</span>
                </h5>
            </div>
        </div>
        <div class="row gx-lg-8 gx-xl-12 gy-8">
            <div class="col-xl-10 col-xxl-9 mx-auto">
                <div class="swiper-container dots-closer mb-6">
                    <Swiper :space-between="30" :pagination="{ el: '.docssp3', clickable: true }"
                        :modules="[Pagination]" :grab-cursor="true" :breakpoints="{
                            500: { slidesPerView: 1 },
                            768: { slidesPerView: 1 },
                            1024: { slidesPerView: 1 },
                        }">
                        <SwiperSlide v-for="(item, i) in services" :key="i">
                            <div class="row g-10 g-lg-10 align-items-center">
                                <div class="col-12 col-lg-4 text-center">
                                    <img v-if="item.img[0]" :src="item.img[0]" />
                                    <NoImage v-else />
                                </div>
                                <div class="col-12 col-lg-8">
                                    <div class="display-2 mb-3">
                                        <span v-for="(service, j) in services" :key="j"
                                            :class="service.title === item.title ? 'text-sky' : 'text-navy'">
                                            {{ service.title }}<span v-if="j < services.length - 1">. </span>
                                        </span>
                                    </div>
                                    <div class="mb-3">{{ item.description }}</div>
                                    <div class="fs-25 text-bold">{{ content[5]?.text ??
                                        trans('global.phrases.hasto_add_content') }}
                                        <ArrowRightIcon style="width: 24px; height: 24px;" />
                                    </div>
                                </div>
                            </div>
                        </SwiperSlide>
                    </Swiper>
                    <div class="swiper-controls">
                        <div
                            class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal docssp3">
                        </div>
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
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper/modules";
import ArrowRightIcon from 'vue-material-design-icons/ArrowRight.vue';

export default {
    components: { NoImage, imagesLoaded, Swiper, SwiperSlide, ArrowRightIcon },
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
            trans,
            Pagination
        }
    }
}
</script>