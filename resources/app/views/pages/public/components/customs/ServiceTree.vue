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
    <!-- <section id="snippet-3" class="wrapper py-16 scrollSpysection"> -->
        <h2 class="mb-3">Accordion with Icon</h2>
        <p class="lead mb-8">
            Omit the <code class="code">data-bs-parent</code> attribute on each
            <code class="code">.accordion-collapse</code> to make accordion items
            stay open when another item is opened.
        </p>
        <div class="card">
            <div class="card-body mb-n2">
                <div class="accordion accordion-wrapper" id="accordionIconExample">
                    <div class="card accordion-item icon">
                        <div class="card-header" id="headingIconOne">
                            <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseIconOne"
                                aria-expanded="true" aria-controls="collapseIconOne">
                                <span><i class="uil uil-shield-exclamation"></i></span>Secure
                                Payments
                            </button>
                        </div>
                        <!--/.card-header -->
                        <div id="collapseIconOne" class="accordion-collapse collapse show"
                            aria-labelledby="headingIconOne" data-bs-parent="#accordionIconExample">
                            <div class="card-body">
                                <p>
                                    Fusce dapibus, tellus ac cursus commodo, tortor mauris
                                    condimentum nibh, ut fermentum massa justo sit amet risus.
                                    Cras mattis consectetur purus sit amet fermentum. Praesent
                                    commodo cursus magna, vel.
                                </p>
                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.accordion-collapse -->
                    </div>
                    <!--/.accordion-item -->
                    <div class="card accordion-item icon">
                        <div class="card-header" id="headingIconTwo">
                            <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseIconTwo"
                                aria-expanded="false" aria-controls="collapseIconTwo">
                                <span><i class="uil uil-check-circle"></i></span>Daily Updates
                            </button>
                        </div>
                        <!--/.card-header -->
                        <div id="collapseIconTwo" class="accordion-collapse collapse" aria-labelledby="headingIconTwo"
                            data-bs-parent="#accordionIconExample">
                            <div class="card-body">
                                <p>
                                    Fusce dapibus, tellus ac cursus commodo, tortor mauris
                                    condimentum nibh, ut fermentum massa justo sit amet risus.
                                    Cras mattis consectetur purus sit amet fermentum. Praesent
                                    commodo cursus magna, vel.
                                </p>
                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.accordion-collapse -->
                    </div>
                    <!--/.accordion-item -->
                    <div class="card accordion-item icon">
                        <div class="card-header" id="headingIconThree">
                            <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseIconThree"
                                aria-expanded="false" aria-controls="collapseIconThree">
                                <span><i class="uil uil-chart-line"></i></span>Market Research
                            </button>
                        </div>
                        <!--/.card-header -->
                        <div id="collapseIconThree" class="accordion-collapse collapse"
                            aria-labelledby="headingIconThree" data-bs-parent="#accordionIconExample">
                            <div class="card-body">
                                <p>
                                    Fusce dapibus, tellus ac cursus commodo, tortor mauris
                                    condimentum nibh, ut fermentum massa justo sit amet risus.
                                    Cras mattis consectetur purus sit amet fermentum. Praesent
                                    commodo cursus magna, vel.
                                </p>
                            </div>
                            <!--/.card-body -->
                        </div>
                        <!--/.accordion-collapse -->
                    </div>
                    <!--/.accordion-item -->
                </div>
                <!--/.accordion -->
            </div>
            <!--/.card-body -->
            <div class="card-footer position-relative">
                <a class="collapse-link collapsed stretched-link" data-bs-toggle="collapse" href="#collapse-3">View
                    example's code</a>
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
