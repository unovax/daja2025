import './assets/css/style.css';
import 'jsvectormap/dist/css/jsvectormap.min.css';
import 'flatpickr/dist/flatpickr.min.css';
import '@fortawesome/fontawesome-free/css/all.css';
import 'sweetalert2/dist/sweetalert2.min.css';

import Notifications from '@kyvg/vue3-notification'
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import VueApexCharts from 'vue3-apexcharts';


import App from './App.vue';
import router from '@/router';

// Import FontAwesome configuration
import { FontAwesomeIcon } from './plugins/fontawesome';

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(VueApexCharts);
app.use(Notifications)

// Register FontAwesome component globally
app.component('font-awesome-icon', FontAwesomeIcon);

app.mount('#app');


