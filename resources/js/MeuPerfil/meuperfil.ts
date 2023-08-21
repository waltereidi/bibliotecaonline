import { createApp } from 'vue/dist/vue.esm-bundler';
import DadosMeuPerfil from "../components/MeuPerfil/DadosMeuPerfil.vue";
import LivrosMeuPerfil from "../components/MeuPerfil/LivrosMeuPerfil.vue";

const meuPerfil = createApp();
meuPerfil.component('dadosmeuperfil' , DadosMeuPerfil).component('livrosmeuperfil', LivrosMeuPerfil);
meuPerfil.mount('#meuPerfil');
