<template>
    <div class="container py-6 py-md-16 text-center">
        <div class="row pb-7">
            <div class="col-xl-9 col-xxl-8 mx-auto">
                <h2 class="display-1 text-light">
                    {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
                </h2>
                <h5 class="display-6 text-navy">
                    {{ content[1]?.text ?? trans('global.phrases.hasto_add_content') }}
                </h5>

            </div>
        </div>
        <div class="row g-6">
            <div class="col-12 col-lg-4">
                <div class="counter-text-xxl text-navy counter">
                    +<Counter parentClass="" :min="0" :max="content[2]?.text ??
                        trans('global.phrases.hasto_add_content')" :time="500"  /> %
                    <!-- Component for counting number with intersetion observer from omponents>common>counter -->
                </div>

                <p class="fs-23 text-bold text-navy">{{ content[3]?.text ??
                    trans('global.phrases.hasto_add_content') }}</p>
            </div>
            <div class="col-12 col-lg-4">
                <div class="counter-text-xxl text-navy counter">
                     <Counter parentClass="" :min="0" :max="content[4]?.text ??
                        trans('global.phrases.hasto_add_content')" :time="500" /> %
                    <!-- Component for counting number with intersetion observer from omponents>common>counter -->
                </div>

                <p class="fs-23 text-bold text-navy">{{ content[5]?.text ??
                    trans('global.phrases.hasto_add_content') }}</p>
            </div>
            <div class="col-12 col-lg-4">
                <div class="counter-text-xxl text-navy counter">
                    -<Counter parentClass="" :min="0" :max="content[6]?.text ??
                        trans('global.phrases.hasto_add_content')" :time="500"  /> %
                    <!-- Component for counting number with intersetion observer from omponents>common>counter -->
                </div>

                <p class="fs-23 text-bold text-navy">{{ content[7]?.text ??
                    trans('global.phrases.hasto_add_content') }}</p>
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
        img: {
            type: String,
            default: [],
        },
        extradata: {
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