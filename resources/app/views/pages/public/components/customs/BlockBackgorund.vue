<template>
    <section class="wrapper image-wrapper bg-image bg-overlay text-white"
        style="background-image: url(/assets/img/home/sec2.jpg)">
        <div class="container py-14 py-md-17 text-center">
            <i class="uil-desktop-cloud-alt text-white fs-30 opacity-50"></i>
            <div class="row mt-3">
                <div class="col-xl-9 col-xxl-8 mx-auto">
                    <h3 class="display-3 mb-10 px-xl-10 px-xxl-15 text-light">
                        Desarrollo de Tiendas Online
                    </h3>
                    <div class="fs-lg">
                    Realizamos el diseño de Tiendas Online, desarrollamos con las últimas tecnologías disponibles, para
                    que su Tienda Online tenga un mayor alcance. VENDA SUS PRODUCTOS ONLINE! 
                    </div>
                    <a href="#" class="btn btn-outline-gradient gradient-7 rounded-pill mt-3"><span>Cotize con nosotros</span></a>

                    <!-- /.swiper-container -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
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