import { createApp } from 'vue/dist/vue.esm-bundler';
import PerfilUsuario from "@/components/PerfilUsuario/PerfilUsuario.vue";
import { store } from "@/Store/store";


const perfilUsuario = createApp();
perfilUsuario.component('perfilusuario', PerfilUsuario);

perfilUsuario.use(store);
perfilUsuario.mount('#perfilUsuario');
