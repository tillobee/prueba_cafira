import './bootstrap';

import { createApp } from 'vue';
import Contacto from './components/Contacto.vue'

const app = createApp({})

app.component('Contacto',Contacto)

app.mount('#app')