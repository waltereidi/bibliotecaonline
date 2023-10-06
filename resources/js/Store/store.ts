export { store };
import { createStore } from "vuex";
const store = createStore({

    mutations: {
        openModal(state) {
            document.getElementById('documentBody').style.overflow= 'hidden';
        },
        closeModal(state) {
            document.getElementById('documentBody').style.overflow = "auto";
        }
    }

});
