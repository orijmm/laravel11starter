<template>
    <div class="container pt-13 pt-md-15 pb-9 pb-md-11">
        <div class="row align-items-center mb-7">
            <div class="col-md-8 col-lg-8 col-xl-7 col-xxl-6 pe-lg-17" data-aos="zoom-in" data-aos-once="true">
                <h2 class="display-4 mb-3">{{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}</h2>
                <p class="lead fs-lg">{{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}</p>
            </div>
        </div>

        <div class="projects-tiles">
            <div class="project grid grid-view">
                <div ref="isotopeContainer" class="d-flex">
                    <div v-for="(item, i) in services" :key="item.id"
                        :class="`item p-4 col-md-6 ${i == 1 ? 'mt-md-17' : ''} `">
                        <figure class="lift rounded mb-6" data-aos="zoom-in" data-aos-once="true">
                            <router-link :to="generateUrl(item)">
                                <img v-if="item.img[0] ?? false" :src="item.img[0]" class="w-[100%]"
                                    alt="servicesimg" />
                                <NoImage v-else />
                            </router-link>
                        </figure>
                        <div :class="['post-category', item.link_color_class]">
                            {{ item.description }}
                        </div>
                        <router-link :to="generateUrl(item)">
                            <h3 class="post-title">{{ item.title }}</h3>
                        </router-link>
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
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

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
        const route = useRoute();
        const router = useRouter();
        const isotopeContainer = ref();
        const isotope = ref();

        const initIsotop = async () => {
            const Isotope = (await import("isotope-layout")).default;
            isotope.value = new Isotope(isotopeContainer.value, {
                itemSelector: ".item",
                layoutMode: "masonry", // o 'fitRows'
            });

            imagesLoaded(isotopeContainer.value).on("progress", function () {
                isotope.value.layout();
            });
        };
        onMounted(() => {
            initIsotop();
        });
        const generateUrl = (item) => {
            if (item.page_id && item.page && item.page.slug) {
                return { name: "webpages", params: { slug: item.page.slug } };
            }
            return "#";
        };
        return {
            trans,
            isotopeContainer,
            generateUrl
        }
    }
}
</script>