<script lang="ts">
import config from "@/../json/bibliotecaconfig.json";
import ModalFormulario from './Opcoes/ModalFormulario.vue';
import ModalExcluir from './Opcoes/ModalExcluir.vue';
export default {
    props:
    {
        datasource: {
            type: Object,
            required: true,

        },
        api_token:{
            type:String,
            required : true ,
        }
    },
    components: {
        ModalFormulario,
        ModalExcluir,
    },
    data() {
        return {
            configDataSource: config,
        }
    },
    methods: {
        childEnviarModalFormulario() {

        }
    }
}
</script>
<template>
    <div class="card">
        <div class="card--titulo">
            <h4>{{ datasource.titulo }}</h4>

        </div>
        <div class="card--autor">
            <p class="text-muted">{{ datasource.autores_nome }}</p>
        </div>
        <div class="card--media">

            <img :src="datasource.capalivro ?? configDataSource.capaLivroDefault" />
        </div>
        <div class="card--actions">
            <div class="card--actions__left">
                <ModalFormulario :parentdatasource="datasource" :api_token="api_token"
                    @enviarModalFormularioAdicionar="childEnviarModalFormulario"></ModalFormulario>

            </div>
            <div class="card--actions__right">
                <ModalExcluir :title="'Confirma exclusão'"
                    :message="'Após confirmar a exclusão do livro sua ação não podera ser desfeita.'"></ModalExcluir>
            </div>
        </div>


    </div>
</template>

<style scoped>
@import "@/../sass/MeuPerfil/CardGrid/cardGrid.scss";
@import "material-icons/iconfont/material-icons.css";
</style>

