<script lang="ts">
import Card from "@/components/MeuPerfil/CardGrid/Card.vue";
import LivrosDataSource from "@/../json/gridContainerDataSource.json";
import ModalFormularioAdicionar from "./Opcoes/ModalFormularioAdicionar.vue";
import Paginacao from "@/components/Utils/Paginacao.vue";

export default {
    components: {
        Card,
        ModalFormularioAdicionar,
        Paginacao,
    },
    data() {
        return {
            livrosDataSource: LivrosDataSource,
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
    <div class="container">

        <div class="container--cardGridHeader">

            <div class="container--cardGridHeader__left">
                <Paginacao :quantidade="30" :multiplicador="6" :limitePaginacao="10" :travarPaginacao="false"
                    @retornaPaginacao="childRetornaPaginacao"></Paginacao>
            </div>
            <div class="container--cardGridHeader__right">
                <ModalFormularioAdicionar></ModalFormularioAdicionar>
            </div>

        </div>
        <div class="container--cardContainer">

            <div v-for="livro in livrosDataSource">
                <Card :dataSource="livro"></Card>
            </div>
        </div>
        <div class="container--cardContainerFooter">


        </div>
    </div>
</template>

<style scoped >
@import 'material-icons/iconfont/material-icons.css';
@import '@/../sass/MeuPerfil/CardGrid/cardGridContainer.scss';
</style>
