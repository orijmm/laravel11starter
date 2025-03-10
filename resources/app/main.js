import { createApp } from 'vue'
import { createPinia } from 'pinia'

import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import "swiper/css";
import "swiper/css/pagination";

import router from "@/router";
import i18n from "@/plugins/i18n";
import App from "@/App";
import mdiPlugin from "@/plugins/mdicons"; // Ajusta la ruta a donde tengas `mdi.js`
import AOS from 'aos';
import "aos/dist/aos.css";
import VSmoothScroll from 'v-smooth-scroll';
import initClipboard from "../app/views/pages/public/template/utlis/initClipboard";
import initPrism from "../app/views/pages/public/template/utlis/initPrism";
import initPlayer from "../app/views/pages/public/template/utlis/initVideoplayer";
import { injectSvg } from "../app/views/pages/public/template/utlis/injextSvg";

//Componentes
import HeadersHeader from "../app/views/pages/public/template/components/home/Header";
import Hero from "../app/views/pages/public/template/components/home/Hero";
import Features from "../app/views/pages/public/template/components/home/Features";
import Facts from "../app/views/pages/public/template/components/home/Facts";
import Testimonials from "../app/views/pages/public/template/components/home/Testimonials";
import Projects from "../app/views/pages/public/template/components/home/Projects";
import Features2 from "../app/views/pages/public/template/components/home/Features2";
import Footer from "../app/views/pages/public/template/components/home/Footer";
import Footer2 from "../app/views/pages/public/template/components/home/Footer2";
import Lightbox from "../app/views/pages/public/template/components/base/Lightbox";
import Menu2 from "../app/views/pages/public/template/components/base/Menu2";
import Socials from "../app/views/pages/public/template/components/base/Socials";
import Links from "../app/views/pages/public/template/components/base/Links";
import CircleProgressbar from "../app/views/pages/public/template/components/base/CircleProgressbar";
import Scrolltop from "../app/views/pages/public/template/components/base/Scrolltop";
import LineProgressbar from "../app/views/pages/public/template/components/base/LineProgressbar";
import ModalVideo from "../app/views/pages/public/template/components/base/ModalVideo";

const app = createApp(App)
    .use(AOS.init({ disable: 'phone' }));

app.use(VSmoothScroll, {
    duration: 800, // Duración del scroll en milisegundos
    updateHistory: false, // No actualizar el hash en la URL
});

app.use(createPinia());

app.use(router);
app.use(i18n);
app.use(mdiPlugin);

const components = {
    // 'BaseNavbar': BaseNavbar,
    // 'Footer': Footer,
    // 'Content': Content,
    'HeadersHeader': HeadersHeader,
    'Hero': Hero,
    'Features': Features,
    'Facts': Facts,
    'Testimonials': Testimonials,
    'Projects': Projects,
    'Features2': Features2,
    'Footer': Footer,
    'Footer2': Footer2,
    'Lightbox': Lightbox,
    'Menu2': Menu2,
    'Socials': Socials,
    'Links': Links,
    'CircleProgressbar': CircleProgressbar,
    'Scrolltop': Scrolltop,
    'LineProgressbar': LineProgressbar,
    'ModalVideo': ModalVideo
};
Object.entries(components).forEach(([name, component]) => {
    app.component(name, component);
});

app.mount('#app');

// Ejecutar utilidades después de montar la app
initPrism();
initClipboard();
initPlayer();
injectSvg();


