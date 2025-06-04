<template>
    <Swiper :space-between="30" :pagination="{ el: '.docss1p', clickable: true }" :modules="[Pagination, Navigation]"
        :navigation="{
            prevEl: '.docss1nbp',
            nextEl: '.docss1nbn',
        }" :grab-cursor="true" :breakpoints="{
            500: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
            1200: { slidesPerView: 3 },
        }">
        <SwiperSlide v-for="(photo, index) in images" :key="index"  class="d-flex align-items-center">
            <figure class="overlay overlay-1 hover-scale rounded mb-0">
                <a href="#" @click.prevent="setActiveLightBox(true, i)">
                    <img :src="photo" alt="imascarousel" />
                    <span class="bg"></span>
                </a>
                <figcaption>
                    <h5 class="from-top mb-0">{{ trans('global.phrases.preview_zoom') }}</h5>
                </figcaption>
            </figure>
        </SwiperSlide>
    </Swiper>
    <div class="swiper-controls">
        <div
            class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal docss1p">
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button swiper-button-prev docss1nbp"></div>
            <div class="swiper-button swiper-button-next docss1nbn"></div>
        </div>
    </div>
    <Lightbox :images="images" :activeLightBox="activeLightBox" :firstSlideIndex="currentSlideIndex"
        @setActiveLightBox="setActiveLightBox" />
</template>

<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination } from "swiper/modules";
import { trans } from "@/helpers/i18n";
import { ref } from "vue";
export default {
    name: 'Carousel',
    components: { Swiper, SwiperSlide },
    props: {
        images: {
            type: Array,
            default: []
        }
    },
    setup() {
        const currentSlideIndex = ref();
        const activeLightBox = ref(false);

        const setActiveLightBox = (val, i) => {
            currentSlideIndex.value = i;
            activeLightBox.value = val;
        };

        return {
            trans,
            Pagination,
            Navigation,
            currentSlideIndex,
            activeLightBox,
            setActiveLightBox
        }
    }
};
</script>
