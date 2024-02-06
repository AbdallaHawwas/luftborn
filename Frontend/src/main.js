import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router';
import * as bootstrap from 'bootstrap';
import store from './store';

createApp(App)
.use(router)
.use(bootstrap)
.use(store)
.mount('#app')
