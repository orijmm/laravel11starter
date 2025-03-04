import { createApp } from 'vue'
import { createPinia } from 'pinia'

import router from "@/router";
import i18n from "@/plugins/i18n";
import App from "@/App";
import mdiPlugin from "@/plugins/mdicons"; // Ajusta la ruta a donde tengas `mdi.js`
import AOS from 'aos'
import 'aos/dist/aos.css'
import VSmoothScroll from 'v-smooth-scroll';

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

app.mount('#app');




