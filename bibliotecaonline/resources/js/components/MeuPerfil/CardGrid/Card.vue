<script lang="ts">
import config from "@/../json/bibliotecaconfig.json";
import ModalFormulario from './Opcoes/ModalFormulario.vue';
import ModalExcluir from './Opcoes/ModalExcluir.vue';
import { meuperfilStore } from "@/Store/meuperfilStore";

export default {
    props:
    {
        datasource: {
            type: Object,
            required: true,

        },
    },
    data() {
        return {
            configDataSource: config,
            meuperfilStore: meuperfilStore(),
        }
    },
    methods: {
       async childConfirmarExcluir(){
            const retorno = await this.meuperfilStore.deleteLivros(this.datasource.id);


    },
    },
    components:{
        ModalExcluir ,
        ModalFormulario
    }

}
</script>
<template>
    <div class="card">
        <div class="card--titulo">
            <h4>{{ (datasource.titulo.length>20)?(datasource.titulo.substring(0,20))+'...':datasource.titulo  }}</h4>

        </div>
        <div class="card--autor">
            <p class="text-muted">{{ (datasource.autores_nome.length>30)?(datasource.autores_nome.substring(0,30))+'...':datasource.autores_nome }}</p>
        </div>
        <div class="card--media">

            <img :src="datasource.capalivro ?? configDataSource.capaLivroDefault" />
        </div>
        <div class="card--actions">
            <div class="card--actions__left">
                <ModalFormulario :parentdatasource="datasource"></ModalFormulario>

            </div>
            <div class="card--actions__right">
                <ModalExcluir :title="'Confirma exclusão'"
                    :message="'Após confirmar a exclusão do livro sua ação não podera ser desfeita.'"
                    @confirmar="childConfirmarExcluir"
                    ></ModalExcluir>
            </div>
        </div>


    </div>
</template>

<style scoped>
@import "@/../sass/MeuPerfil/CardGrid/cardGrid.scss";
@import "material-icons/iconfont/material-icons.css";
</style>

