<template>
    <section id="snippet-3" class="wrapper bg-light wrapper-border">
        <div class="container pt-15 pt-md-17 pb-13 pb-md-15">
            <div class="row gx-lg-8 gx-xl-10 align-items-center">
                <div class="col-lg-6">
                    <figure class="rounded">
                        <img src="/assets/img/photos/device.png" alt="hostingp" />
                    </figure>
                </div>
                <!-- /column -->
                <div class="col-lg-6">
                    <h2 class="fs-15 text-uppercase text-muted mb-3">How It Works</h2>
                    <h3 class="display-4 mb-5">
                        Download the app, create your profile and voilà, you're all set!
                    </h3>
                    <p class="mb-8">
                        Donec ullamcorper nulla non metus auctor fringilla. Cras mattis
                        consectetur purus sit amet fermentum. Integer posuere erat a ante
                        venenatis dapibus posuere velit aliquet. Nulla vitae elit libero.
                        Etiam porta sem malesuada magna mollis euismod. Fusce dapibus,
                        tellus ac cursus commodo.
                    </p>
                    <div class="row gy-6 gx-xxl-8 process-wrapper">
                        <div v-for="(item, index) in services" class="col-md-4" :key="index">
                            <div class="icon-svg" :class="item.icon_color_class" 
                                :style="{ '-webkit-mask-image': `url(${item.icon})`, 'mask-image': `url(${item.icon})` }">
                            </div>
                            <h4 class="mb-1">{{ item.title }}</h4>
                            <p class="mb-0">{{ item.description }}</p>
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
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