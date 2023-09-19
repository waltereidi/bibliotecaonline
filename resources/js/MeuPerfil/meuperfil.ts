import { createApp } from 'vue/dist/vue.esm-bundler';
import MeuPerfil from "../components/MeuPerfil/MeuPerfil.vue";
import {store} from "@/store";
const meuPerfil = createApp();
meuPerfil.use(store);
meuPerfil.component('meuperfil', MeuPerfil);

meuPerfil.mount('#meuPerfil');
