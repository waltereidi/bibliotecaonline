import { createApp } from 'vue/dist/vue.esm-bundler';
import Paginainicial from "@/components/Paginainicial/PaginaInicial.vue";
import { createStore } from "vuex";

const paginainicial = createApp();
paginainicial.component('paginainicial' , Paginainicial);

const store = createStore({
    state() {
        return {
            lockScreen: false ,
        }
    },
    mutations: {
        openModal(state) {
            state.lockScreen= true;
        },
        closeModal(state) {
            state.lockScreen = false;
        }
    },
    getters: {
        getLockScreen(state) {
            return state.lockScreen;
        }
    }

});
paginainicial.use(store);
paginainicial.mount('#paginainicial');
