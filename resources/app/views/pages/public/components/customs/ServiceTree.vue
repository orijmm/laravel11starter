<template>
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
                    <div id="collapseIconOne" class="accordion-collapse collapse show" aria-labelledby="headingIconOne"
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
                    <div id="collapseIconThree" class="accordion-collapse collapse" aria-labelledby="headingIconThree"
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
            </div>
            <!--/.accordion -->
        </div>
        <!--/.card-body -->
        <div class="card-footer position-relative">
            <a class="collapse-link collapsed stretched-link" data-bs-toggle="collapse" href="#collapse-3">View
                example's code</a>
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
