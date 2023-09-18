import { createApp } from 'vue/dist/vue.esm-bundler';
import DadosMeuPerfil from "../components/MeuPerfil/MeuPerfil.vue";
import LivrosMeuPerfil from "../components/MeuPerfil/LivrosMeuPerfil.vue";

const meuPerfil = createApp();
meuPerfil.component('meuperfil' , DadosMeuPerfil).component('livrosmeuperfil', LivrosMeuPerfil);
meuPerfil.mount('#meuPerfil');
