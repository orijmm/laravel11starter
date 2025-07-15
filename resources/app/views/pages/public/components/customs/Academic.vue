<!-- <template>
    <div class="row gy-10 gy-sm-13 gx-md-8 gx-xl-12 align-items-center mb-10 mb-md-12">
        <div class="col-lg-6">
            <div class="row gx-md-5 gy-5">
                <div class="col-md-6">
                    <figure class="rounded">
                        <img src="/assets/img/photos/g14.jpg" alt="photo" />
                    </figure>
                </div>
                <div class="col-md-6 align-self-end">
                    <figure class="rounded">
                        <img src="/assets/img/photos/g15.jpg" alt="photo" />
                    </figure>
                </div>
                <div class="col-12">
                    <figure class="rounded mx-md-5">
                        <img src="/assets/img/photos/g16.jpg" alt="photo" />
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <h2 class="fs-15 text-uppercase text-muted mb-3">Who Are We?</h2>
            <h3 class="display-3 ls-sm mb-5">
                Company that believes in the power of creative strategy.
            </h3>
            <p class="mb-6">
                Cum sociis natoque penatibus et magnis dis parturient montes, nascetur
                ridiculus mus. Cras justo odio, dapibus ac facilisis in, egestas eget
                quam. Praesent commodo cursus magna, vel scelerisque nisl consectetur
                et. Cum sociis natoque penatibus et magnis dis parturient montes,
                nascetur ridiculus mus. Aenean lacinia bibendum nulla sed.
            </p>
            <div class="row gy-3 gx-xl-8">
                <div class="col-xl-6">
                    <ul class="icon-list bullet-primary mb-0">
                        <li v-for="(item, index) in checklistItems.slice(0, 2)" :key="index"
                            :class="{ 'mt-3': index > 0 }">
                            <span><i class="uil uil-check"></i></span>
                            <span>{{ item.text }}</span>
                        </li>
                    </ul>
                </div>
                <div class="col-xl-6">
                    <ul class="icon-list bullet-primary mb-0">
                        <li v-for="(item, index) in checklistItems.slice(2, 4)" :key="index"
                            :class="{ 'mt-3': index > 0 }">
                            <span><i class="uil uil-check"></i></span>
                            <span>{{ item.text }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row gx-lg-8 gx-xl-12 gy-6 mb-15 mb-md-18">
        <div v-for="(service, i) in services" :key="service.id" class="col-lg-4">
            <div class="d-flex flex-row">
                <div>
                    <div class="icon-svg icon-svg-xs  me-5 mt-1" :class="service.icon_color_class"
                        :style="{ '-webkit-mask-image': `url(${service.icon})`, 'mask-image': `url(${service.icon})` }">
                    </div>
                </div>
                <div>
                    <h4 class="fs-20 ls-sm">{{ service.title }}</h4>
                    <p class="mb-2">{{ service.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template> -->

<template>
    <!-- <section class=""
        style="background-image: url(/assets/img/map.png)"> -->
        <div class="container py-0 py-md-17">
            <div class="row">
                <div class="col-lg-6 col-xl-5 mx-auto">
                    <h2 class="display-4 mb-3 text-center">Join Our Community</h2>
                    <p class="lead mb-5 px-md-16 px-lg-3">
                        We are trusted by over 5000+ clients. Join them by using our
                        services and grow your business.
                    </p>
                    <nuxt-link to="/signup" class="btn btn-primary rounded-pill">Join Us</nuxt-link>
                </div>
            </div>
        </div>
    <!-- </section> -->
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
