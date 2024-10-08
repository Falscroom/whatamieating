import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import { VueQueryPlugin } from 'vue-query';

import App from './app/App.vue';
import {i18n, primeVue} from './app/plugins';
import {router} from './interfaces/router';



const app = createApp(App);

app.use(PrimeVue, primeVue);
app.use(i18n);
app.use(VueQueryPlugin);
app.use(router);

app.mount('#app');
