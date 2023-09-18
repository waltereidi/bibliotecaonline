import { createApp } from 'vue/dist/vue.esm-bundler';
import PerfilUsuario from "@/components/PerfilUsuario/PerfilUsuario.vue";
import { store } from "@/store.ts";


const perfilUsuario = createApp();
perfilUsuario.component('perfilusuario', PerfilUsuario);

perfilUsuario.use(store);
perfilUsuario.mount('#perfilUsuario');
