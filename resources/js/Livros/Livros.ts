import { store } from "@/store.ts";
import Livros from "@/components/Livros/Livros.vue";
import { createApp } from 'vue/dist/vue.esm-bundler';


const livros = createApp();

livros.component('livros', Livros);
livros.use(store);
livros.mount('#livros');
