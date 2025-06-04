<template>
    <div class="violet-theme urbanist-font">
        <div class="content-wrapper">
            <HeadersHome :menus="menus" />
            <!-- <Content :page="page" :extradata="extradata" /> -->

            <section class="wrapper image-wrapper bg-image bg-overlay text-white hero-background">
                <div class="container pt-17 pb-12 pt-md-19 pb-md-16 text-center">
                    <div class="row">
                        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                            <div class="post-header">
                                <div class="post-category text-line text-white">
                                    <a v-if="project.data.category" href="#" class="text-reset" rel="category">{{
                                        project.data.category }}</a>
                                </div>
                                <!-- /.post-category -->
                                <h1 class="display-1 mb-3 text-white">
                                    {{ project.data.title }}
                                </h1>
                            </div>
                            <!-- /.post-header -->
                        </div>
                        <!-- /column -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container -->
            </section>
            <section class="wrapper bg-light wrapper-border">
                <div class="container pt-14 pt-md-16 pb-13 pb-md-15">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <article>
                                <h2 v-if="project.data.description" class="display-6 mb-4">{{
                                    trans('global.pages.project_details') }}</h2>
                                <div class="row gx-0">
                                    <div v-if="project.data.description" class="col-md-9 text-justify">
                                        <p>{{ project.data.description }}</p>
                                    </div>
                                    <!--/column -->
                                    <div class="col-md-3 ms-auto">
                                        <ul class="list-unstyled">
                                            <li v-if="project.data.date">
                                                <h5 class="mb-1">{{ trans('global.pages.project_date') }}</h5>
                                                <p>{{ date(project.data.date, 'D MMMM YYYY') }}</p>
                                            </li>
                                            <li v-if="project.data.client_name">
                                                <h5 class="mb-1">{{ trans('global.pages.project_client_name') }}</h5>
                                                <p>{{ project.data.client_name }}</p>
                                            </li>
                                        </ul>

                                        <a v-if="project.data.url" target="_blank" :href="project.data.url"
                                            class="more hover">
                                            {{ trans('global.pages.project_url') }}
                                        </a>

                                    </div>
                                    <!--/column -->
                                </div>
                                <!--/.row -->
                            </article>
                            <!-- /.project -->
                        </div>
                        <!-- /column -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container -->
                <div v-if="project.data.img" class="container-fluid px-md-6">
                    <div class="row gx-md-8 gy-10 gy-md-13 isotope">
                        <div v-for="(elm, i) in project.data.img" :key="project.data.id" class="project item col-md-6 col-xl-4">
                            <figure class="rounded mb-6">
                                <img :src="elm" :alt="project.data.img_alt" />
                                <div class="item-link cursor-pointer" @click="() => setActiveLightBox(true, i)">
                                    <i class="uil uil-focus-add"></i>
                                </div>
                            </figure>
                        </div>
                        <!-- /.item -->
                    </div>
                </div>
            </section>
            <Lightbox :images="images" :activeLightBox="activeLightBox" :firstSlideIndex="currentSlideIndex"
                @setActiveLightBox="setActiveLightBox" />
        </div>
        <Footer2 :menus="menus" />
    </div>
</template>
<script>
import { trans } from "@/helpers/i18n";
import { date } from "@/helpers/datetimeFormat"
import Footer from '@/views/pages/public/template/components/base/Footer';
import Content from '@/views/pages/public/home/Content';
import { useRoute } from 'vue-router';
import { useAlertStore } from "@/stores";
import { onMounted, reactive, ref } from 'vue';
import { getResponseError, prepareQuery } from "@/helpers/api";
import ModelService from '@/services/ModelService';
import SettingService from '@/services/SettingService';
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper/modules";

export default {
    name: 'DefaultLayout',
    components: { Content, Footer, Swiper, SwiperSlide },
    setup() {
        const service = new ModelService;
        const settings = new SettingService();
        const alertStore = useAlertStore();
        const route = useRoute();

        // Variables reactivas
        const menus = reactive({
            total: 0,
            data: [],
            logo: null,
            webdata: []
        });
        const project = reactive({
            data: []
        });

        const currentSlideIndex = ref();
        const activeLightBox = ref(false);
        const images = ref([]);

        //metodos
        function fetchPage() {
            //Colocar menu-top como menu principal
            let query = prepareQuery({ search: 'menu-top' });
            service
                .index(query, 'menus/searchname')
                .then((response) => {
                    menus.data = response.data.model.items;
                    menus.total = response.data.model.length;
                })
                .catch((error) => {
                    alertStore.error(getResponseError(error));
                });

            //project
            service
                .find(route.params.id, 'manteiners/projects')
                .then((response) => {
                    project.data = response.data.model ?? [];
                    images.value = response.data.model.img;
                })
                .catch((error) => {
                    alertStore.error(getResponseError(error));
                    console.log(error);
                });

            //Setting
            settings.find(1)
                .then((response) => {
                    menus.logo = response.data.model.logo_url;
                    menus.webdata = response.data.model;
                });
        }

        onMounted(() => {
            fetchPage();
        });

        const setActiveLightBox = (val, i) => {
            currentSlideIndex.value = i;
            activeLightBox.value = val;
        };
        return {
            trans,
            date,
            menus,
            project,
            Pagination,
            currentSlideIndex,
            activeLightBox,
            setActiveLightBox,
            images
        }
    }
}
</script>

<style>
.cover-gradient {
    background: linear-gradient(169.4deg,
            rgba(57, 132, 244, 0.04) -6.01%,
            rgba(12, 211, 255, 0.04) 36.87%,
            rgba(47, 124, 240, 0.04) 78.04%,
            rgba(14, 101, 232, 0.04) 103.77%);
}

.cover-gradient-2 {
    background: linear-gradient(169.4deg,
            rgba(57, 132, 244, 0.1) -6.01%,
            rgba(12, 211, 255, 0.1) 36.87%,
            rgba(47, 124, 240, 0.1) 78.04%,
            rgba(14, 101, 232, 0.1) 103.77%);
}

.bg-blue-gradient,
.text-gradient {
    background: linear-gradient(136.91deg, #468ef9 -12.5%, #0c66ee 107.5%);
}

.text-gradient {
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.slide-enter-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: ease-in;
    -webkit-transition-timing-function: ease-in;
    -o-transition-timing-function: ease-in;
    transition-timing-function: ease-in;
}

.slide-leave-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to,
.slide-leave {
    max-height: 100px;
    overflow: hidden;
}

.slide-enter,
.slide-leave-to {
    overflow: hidden;
    max-height: 0;
}
</style>