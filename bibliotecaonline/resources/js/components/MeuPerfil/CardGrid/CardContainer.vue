<script lang="ts">
import Card from "@/components/MeuPerfil/CardGrid/Card.vue";
import ModalFormularioAdicionar from "./Opcoes/ModalFormularioAdicionar.vue";
import Paginacao from "@/components/Utils/Paginacao.vue";
import { meuperfilStore } from "@/Store/meuperfilStore";



export default {
    data(){
        return {
            meuperfilStore : meuperfilStore(),
        }
    },
    components: {
        Card,
        ModalFormularioAdicionar,
        Paginacao,

    },
    methods: {
        childRetornaPaginacao(pagina , multiplicador ){
            this.meuperfilStore.atualizarDataSource( multiplicador , pagina);
        }
    }

}
</script>
<template>


    <div class="Container" >
        <div class="Container--cardGridHeader">
            <div class="Container--cardGridHeader__left">
                <Paginacao :quantidade="meuperfilStore.getQuantidade" :multiplicador="6" :limitePaginacao="8" :travarPaginacao="meuperfilStore.getMessages.carregando"
                    v-if="meuperfilStore.getQuantidade>6 && meuperfilStore.getQuantidade!= null"
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
