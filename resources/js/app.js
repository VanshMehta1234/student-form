import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';
import store from './store';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';

require('./bootstrap');

const app = createApp(App);
app.use(router);
app.use(store);
app.mount('#app'); 