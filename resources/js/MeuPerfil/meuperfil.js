import { createApp } from 'vue/dist/vue.esm-bundler';
import DadosMeuPerfil from "../components/MeuPerfil/DadosMeuPerfil.vue";
import LivrosDoMeuPerfil from "../components/MeuPerfil/LivrosDoMeuPerfil.vue";

const meuPerfil = createApp();
meuPerfil.component('dadosmeuperfil' , DadosMeuPerfil).component('livrosdomeuperfil', LivrosDoMeuPerfil);
meuPerfil.mount('#meuPerfil');
