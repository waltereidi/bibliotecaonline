<script lang="ts">
import Card from "@/components/MeuPerfil/CardGrid/Card.vue";
import ModalFormularioAdicionar from "./Opcoes/ModalFormularioAdicionar.vue";
import Paginacao from "@/components/Utils/Paginacao.vue";
import Carregando from "@/components/Utils/Carregando.vue";
import Sucesso from "@/components/Utils/Sucesso.vue";
import Alerta from"@/components/Utils/Alerta.vue";
import Erro from '@/components/Utils/Erro.vue';
import { meuperfilStore } from "@/Store/meuperfilStore";



export default {
    props : {
        datasourcelivros : {
            type : Object ,
            required : false ,
        },
        quantidadelivros : {
            type: Number ,
            required : true ,
        },
        api_token : {
            type: String ,
            required : true ,
        },
        datasourcemeuperfil : {
            type : Object ,
            required : true,
        }
    },
    data(){
        return {
            meuperfilStore : meuperfilStore(),
        }
    },
    components: {
        Card,
        ModalFormularioAdicionar,
        Paginacao,
        Carregando ,
        Sucesso ,
        Erro,
        Alerta ,
    },
    methods: {
        childRetornaPaginacao(quantidade , multiplicador ){

        }
    },
    mounted(){
        this.meuperfilStore.setUser(this.datasourcemeuperfil , this.api_token , this.quantidadelivros , this.datasourcelivros)
    }

}
</script>
<template>
    <Carregando :show="meuperfilStore.messages.carregando"></Carregando>
    <Sucesso :show="meuperfilStore.messages.sucesso"></Sucesso>
    <Erro :show="meuperfilStore.messages.erro"></Erro>
    <Alerta :show="meuperfilStore.messages.alerta"></Alerta>

    <div class="Container" >
        {{ meuperfilStore.getApiToken }}

        <div class="Container--cardGridHeader">

            <div class="Container--cardGridHeader__left">
                <Paginacao :quantidade="meuperfilStore.getQuantidade" :multiplicador="6" :limitePaginacao="8" :travarPaginacao="meuperfilStore.getMessages.carregando"
                    v-if="meuperfilStore.quantidadelivros>6 && meuperfilStore.quantidadelivros!= null"
                    @retornaPaginacao="childRetornaPaginacao"></Paginacao>
            </div>
            <div class="Container--cardGridHeader__right">
                <ModalFormularioAdicionar></ModalFormularioAdicionar>
            </div>

        </div>
        <div class="Container--cardContainer">

            <div v-for="livro in meuperfilStore.getDataSource" v-if="meuperfilStore.getQuantidade>0">
                <Card :datasource="livro" ></Card>
            </div>
        </div>
        <div class="Container--cardContainerFooter">


        </div>
    </div>
</template>

<style scoped >
@import 'material-icons/iconfont/material-icons.css';
@import '@/../sass/MeuPerfil/CardGrid/cardGridContainer.scss';
</style>
