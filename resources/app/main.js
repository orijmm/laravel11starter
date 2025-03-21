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
import initClipboard from "./views/pages/public/template/utlis/initClipboard";
import initPrism from "./views/pages/public/template/utlis/initPrism";
import initPlayer from "./views/pages/public/template/utlis/initVideoplayer";
import { injectSvg } from "./views/pages/public/template/utlis/injextSvg";

//Content
import Content from "./views/pages/public/home/Content";


//Componentes
import HeadersHome from "./views/pages/public/components/customs/Header";
import Hero from "./views/pages/public/components/customs/Hero";
import Features from "./views/pages/public/components/customs/Features";
import Facts from "./views/pages/public/components/customs/Facts";
import Testimonials from "./views/pages/public/components/customs/Testimonials";
import Projects from "./views/pages/public/components/customs/Projects";
import Features2 from "./views/pages/public/components/customs/Features2";
import Footer from "./views/pages/public/components/customs/Footer";
import Footer2 from "./views/pages/public/components/customs/Footer2";
import Lightbox from "./views/pages/public/template/components/base/Lightbox";
import Navbar from "./views/pages/public/template/components/base/Navbar";
import Socials from "./views/pages/public/template/components/base/Socials";
import Links from "./views/pages/public/template/components/base/Links";
import CircleProgressbar from "./views/pages/public/template/components/base/CircleProgressbar";
import Scrolltop from "./views/pages/public/template/components/base/Scrolltop";
import LineProgressbar from "./views/pages/public/template/components/base/LineProgressbar";
import ModalVideo from "./views/pages/public/template/components/base/ModalVideo";
import BlockBackgorund from "./views/pages/public/components/customs/BlockBackgorund";

const app = createApp(App)
    .use(AOS.init({ disable: 'phone' }));


// Ejecutar utilidades después de montar la app
initPrism();
initClipboard();
initPlayer();

app.use(VSmoothScroll, {
    duration: 800, // Duración del scroll en milisegundos
    updateHistory: false, // No actualizar el hash en la URL
});

app.use(createPinia());
app.use(injectSvg());

app.use(router);
app.use(i18n);
app.use(mdiPlugin);

const components = {
    // 'BaseNavbar': BaseNavbar,
    // 'Footer': Footer,
    'Content': Content,
    'HeadersHome': HeadersHome,
    'Hero': Hero,
    'Features': Features,
    'Facts': Facts,
    'Testimonials': Testimonials,
    'Projects': Projects,
    'Features2': Features2,
    'Footer': Footer,
    'Footer2': Footer2,
    'Lightbox': Lightbox,
    'Navbar': Navbar,
    'Socials': Socials,
    'Links': Links,
    'CircleProgressbar': CircleProgressbar,
    'Scrolltop': Scrolltop,
    'LineProgressbar': LineProgressbar,
    'ModalVideo': ModalVideo,
    'BlockBackgorund': BlockBackgorund
};
Object.entries(components).forEach(([name, component]) => {
    app.component(name, component);
});

app.mount('#app');


