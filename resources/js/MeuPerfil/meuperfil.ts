import { createApp } from 'vue/dist/vue.esm-bundler';
import MeuPerfil from "../components/MeuPerfil/MeuPerfil.vue";
import {store} from "@/Store/store";
import { createPinia } from 'pinia';
const meuPerfil = createApp();
meuPerfil.use(store);

meuPerfil.use(createPinia());

meuPerfil.component('meuperfil', MeuPerfil);

meuPerfil.mount('#meuPerfil');
