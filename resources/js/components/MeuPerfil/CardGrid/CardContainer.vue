<script lang="ts">
import Card from "@/components/MeuPerfil/CardGrid/Card.vue";
import ModalFormularioAdicionar from "./Opcoes/ModalFormularioAdicionar.vue";
import Paginacao from "@/components/Utils/Paginacao.vue";
import Carregando from "@/components/Utils/Carregando.vue";

export default {
    props : {
        datasourcelivros : {
            type : Object ,
            required : true ,
        },
        quantidadelivros : {
            type: Number ,
            required : true ,
        }
    },
    components: {
        Card,
        ModalFormularioAdicionar,
        Paginacao,
        Carregando ,
    },
    data() {
        return {
            searchBar: '',
        }
    },
    methods: {
        buscar() {

        },
        childRetornaPaginacao(paginacao, multiplicador) {


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
                <ModalFormularioAdicionar></ModalFormularioAdicionar>
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
