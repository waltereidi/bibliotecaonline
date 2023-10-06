import { ref , computed } from "vue";
import { defineStore } from 'pinia';
import { MeuPerfilController } from "@/MeuPerfil/meuperfilController";

export const meuperfilStore = defineStore('meuperfil',{
    state: () => {
        return {
            api_token : 'Bearer ' ,
            users_id : 0 ,
            meuperfil_id: 0 ,
            meuPerfilController : null ,

        }
    },
    getters: {
        getApiToken: (state) => {
          return state.api_token;
        },

    },
    actions: {
        setUser(meuperfil:object , api_token: string )
        {
            this.api_token = api_token ;
            this.users_id = meuperfil.users_id ;
            this.meuperfil_id = meuperfil.meuperfil_id;
            this.meuPerfilController = ref(new MeuPerfilController(api_token));

        },

    }
} );
