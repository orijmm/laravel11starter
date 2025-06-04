<template>
    <section id="snippet-8" class="wrapper bg-light wrapper-border">
        <div class="container pt-15 pt-md-17 pb-13 pb-md-15">
            <div class="row text-center">
                <div class="col-md-10 col-lg-7 mx-auto position-relative">
                    <img src="/assets/img/svg/doodle5.svg" class="w-15 position-absolute d-none d-lg-block"
                        data-delay="1800" style="bottom: -60%; right: 10%" alt="photitoo" />
                    <img src="/assets/img/svg/doodle6.svg" class="h-15 position-absolute d-none d-lg-block"
                        data-delay="1800" style="top: -40%; left: -5%" alt="photitoo" />
                    <h2 class="fs-16 text-uppercase text-muted mb-3">{{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}</h2>
                    <h3 class="display-3 mb-8 px-xl-6">
                        {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
                        <span v-if="content[2]?.text" class="text-gradient gradient-7">{{ content[2]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
                        <span v-if="content[3]?.text">{{ content[3]?.text ?? trans('global.phrases.hasto_add_content') }}</span>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-11 mx-auto">
                    <div class="row gy-10 gy-lg-0 text-center d-flex align-items-center">
                        <div class="col-md-6 col-lg-4 mx-auto mb-n10 mb-lg-0">
                            <figure class="mx-auto ">
                                <img v-if="img[0] ?? false" :src="img[0]" alt="imgp" />
                                <NoImage v-else />
                            </figure>
                        </div>
                        <!-- /column -->
                        <div class="w-100 d-lg-none"></div>
                        <div class="col-md-6 col-lg-4 order-lg-first">
                            <div class="mb-8">
                                <span class="fs-60 lh-1 mb-3 fw-normal text-gradient gradient-7">01</span>
                                <h4 class="fs-20">{{ content[4]?.text ?? trans('global.phrases.hasto_add_content') }}</h4>
                                <p class="mb-0 px-xl-7">
                                    {{ content[5]?.text ?? trans('global.phrases.hasto_add_content') }}
                                </p>
                            </div>
                            <!-- /div -->
                            <div>
                                <span class="fs-60 lh-1 mb-3 fw-normal text-gradient gradient-7">02</span>
                                <h4 class="fs-20">{{ content[6]?.text ?? trans('global.phrases.hasto_add_content') }}</h4>
                                <p class="mb-0 px-xl-7">
                                     {{ content[7]?.text ?? trans('global.phrases.hasto_add_content') }}
                                </p>
                            </div>
                            <!-- /div -->
                        </div>
                        <!-- /column -->
                        <div class="col-md-6 col-lg-4">
                            <div class="mb-8">
                                <span class="fs-60 lh-1 mb-3 fw-normal text-gradient gradient-7">03</span>
                                <h4 class="fs-20">{{ content[8]?.text ?? trans('global.phrases.hasto_add_content') }}</h4>
                                <p class="mb-0 px-xl-7">
                                    {{ content[9]?.text ?? trans('global.phrases.hasto_add_content') }}
                                </p>
                            </div>
                            <div>
                                <span class="fs-60 lh-1 mb-3 fw-normal text-gradient gradient-7">04</span>
                                <h4 class="fs-20">{{ content[10]?.text ?? trans('global.phrases.hasto_add_content') }}</h4>
                                <p class="mb-0 px-xl-7">
                                    {{ content[11]?.text ?? trans('global.phrases.hasto_add_content') }}
                                </p>
                            </div>
                            <!-- /div -->
                        </div>
                        <!-- /column -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
    </section>
</template>

<script>
import { trans } from "@/helpers/i18n";
import NoImage from '@/views/pages/private/website/components/noImage';

export default {
    components: { NoImage },
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