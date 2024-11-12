import {createApp} from 'vue'
import { createPinia } from 'pinia'

import router from "@/router";
import i18n from "@/plugins/i18n";
import App from "@/App";
import mdiPlugin from "@/plugins/mdicons"; // Ajusta la ruta a donde tengas `mdi.js`


const app = createApp(App)

app.use(createPinia());

app.use(router);
app.use(i18n);
app.use(mdiPlugin);

app.mount('#app');




