import { createApp } from 'vue/dist/vue.esm-bundler';
import Paginainicial from "@/components/Paginainicial/PaginaInicial.vue";

import {store} from "@/store.ts";


const paginainicial = createApp();
paginainicial.component('paginainicial' , Paginainicial);

paginainicial.use(store);
paginainicial.mount('#paginainicial');
