import { createApp } from 'vue/dist/vue.esm-bundler';
import Paginainicial from "@/components/Paginainicial/PaginaInicial.vue";

const paginainicial = createApp();
paginainicial.component('paginainicial' , Paginainicial);
paginainicial.mount('#paginainicial');
