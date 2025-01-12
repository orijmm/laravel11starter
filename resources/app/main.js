import { createApp } from 'vue'
import { createPinia } from 'pinia'

import router from "@/router";
import i18n from "@/plugins/i18n";
import App from "@/App";
import mdiPlugin from "@/plugins/mdicons"; // Ajusta la ruta a donde tengas `mdi.js`
import AOS from 'aos'
import 'aos/dist/aos.css'

const app = createApp(App)
    .use(AOS.init());

app.use(createPinia());

app.use(router);
app.use(i18n);
app.use(mdiPlugin);

app.mount('#app');




