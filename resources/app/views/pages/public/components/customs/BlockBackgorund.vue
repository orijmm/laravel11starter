<template>
    <div class="container py-14 py-md-17 text-center">
        <i class="uil-desktop-cloud-alt text-white fs-30 opacity-50"></i>
        <div class="row mt-3">
            <div class="col-xl-9 col-xxl-8 mx-auto">
                <h3 class="display-3 mb-10 px-xl-10 px-xxl-15 text-light">
                    {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
                </h3>
                <div class="fs-lg">
                    {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
                </div>
                <a href="#" class="btn btn-outline-gradient gradient-7 rounded-pill mt-3"><span>{{ content[2]?.text ??
                    trans('global.phrases.hasto_add_content') }}</span></a>
                <!-- /.swiper-container -->
            </div>
            <!-- /column -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</template>

<script>
import { trans } from "@/helpers/i18n";

export default {
    props: {
        content: {
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