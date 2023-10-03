<script lang="ts">
import Card from "@/components/MeuPerfil/CardGrid/Card.vue";
import ModalFormularioAdicionar from "./Opcoes/ModalFormularioAdicionar.vue";
import Paginacao from "@/components/Utils/Paginacao.vue";
import Carregando from "@/components/Utils/Carregando.vue";
import Sucesso from "@/components/Utils/Sucesso.vue";

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
        users_id : {
            type : Number ,
            required : true,
        }
    },
    components: {
        Card,
        ModalFormularioAdicionar,
        Paginacao,
        Carregando ,
    },
    methods: {
        buscar() {

        },
        childRetornaPaginacao(paginacao, multiplicador) {


        }
        childModalAdicionarSucesso( retorno ){

        }
    }

}
</script>
<template>
    <div class="Container" >

        <div class="Container--cardGridHeader">

            <div class="Container--cardGridHeader__left">
                <Paginacao :quantidade="quantidadelivros" :multiplicador="6" :limitePaginacao="8" :travarPaginacao="false"
                    v-if="quantidadelivros>0"
                    @retornaPaginacao="childRetornaPaginacao"></Paginacao>
            </div>
            <div class="Container--cardGridHeader__right">
                <ModalFormularioAdicionar :api_token="api_token" :users_id="users_id" @modalAdicionarSucesso="childModalAdicionarSucesso"></ModalFormularioAdicionar>
            </div>

        </div>
        <div class="Container--cardContainer">

            <div v-for="livro in datasourcelivros" v-if="quantidadelivros>6">
                <Card :datasource="livro"></Card>
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
