<script lang="ts">
import LivroCard from "./LivroCard.vue";
import LivrosDataSource from "@/../json/livrosdoperfils.json";
import Paginacao from "@/components/Utils/Paginacao.vue";
import { PaginainicialController } from "@/Paginainicial/paginainicialController";
export default {
    props: {
        token_aplicativo: {
            required: true,
            type: String,
        }
    },

    components: {
        LivroCard,
        Paginacao,
    },
    data() {
        return {
            paginainicialController: {
                type: typeof PaginainicialController
            },
            dataSource: LivrosDataSource,
            searchBar: '',
            modal: false,
            indiceAtivo: 'Todos',
            indicesDataSource: [] as {
                indice: string,
                quantidade: number,
                tipo: string,
            }[],
        }
    },
    methods: {
        buscar() {
        },
        getDataSourceIndices(nomeIndice: string, tipo: string) {
            this.indiceAtivo = nomeIndice;
        },
        childRetornaPaginacao(paginaAtual: number, multiplicador: number) {

        },
    },
    beforeCreate() {
        this.paginainicialController = new PaginainicialController(this.token_aplicativo);
        this.paginainicialController.getIndices().then(response => {
            this.indicesDataSource = response.data;
        }
        );

        const dados =this.paginainicialController.getDadosBuscaIndice(20, 0 , [{'tipo':'Todos' , 'indice':'todos'}]);
        const dadosRequest = this.paginainicialController.getDadosBuscaIndiceRequest(dados);

        this.paginainicialController.postBuscaIndice(dadosRequest).then(response =>{
            this.dataSource = response.data;
            console.log(this.dataSource);
        });

    },

}
</script>
<template>
    <div class="container">
        <div class="header">
            <img :src="'/imagens/wallpaper.jpg'" />
        </div>
        <div class="headerDivisory">
            <div class="searchBar">

                <label class="mdc-text-field mdc-text-field--filled mdc-text-field--with-trailing-icon">
                    <span class="mdc-floating-label" id="my-label-id" v-if="searchBar === ''">Procurar</span>
                    <input v-model="searchBar" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id">
                    <i @click="buscar" class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing"
                        tabindex="0" role="button">search</i>
                </label>

            </div>
            <div class="indexBar">

                <div v-for="menu in indicesDataSource"
                    :class="{ 'index ativo': menu.indice === indiceAtivo, 'index': menu.indice !== indiceAtivo }"
                    @click="getDataSourceIndices(menu.indice, menu.tipo)">
                    {{ menu.indice }}
                </div>
            </div>
        </div>
        <div class="conteudo">
            <div class="conteudo--leftBar">
                <div class="menuGrid header">
                    <h5>Indices</h5>
                </div>
                <div class="menuGrid">
                    <div v-if="indicesDataSource != null" v-for="(menu, index)  in indicesDataSource" :key="index">
                        <div :class="{ 'menuContent': !(menu.indice === indiceAtivo), 'menuContent ativo': (menu.indice === indiceAtivo) }"
                            @click="getDataSourceIndices(menu.indice, menu.tipo)">
                            <p>{{ (menu.indice.length > 22) ? (menu.indice.substring(0, 22)) + '...' : menu.indice }}</p><em>
                                {{ menu.quantidade }}</em>
                        </div>
                    </div>
                </div>



            </div>
            <div class="conteudo--mainContent">
                <div class="conteudo--mainContent__header">
                    <div class="paginacaoContainer">
                        <div class="paginacaoContainer--left">
                        </div>
                        <div class="paginacaoContainer--right">
                            <Paginacao :multiplicador="500" :quantidade="dataSource.quantidadeTotal" :limitePaginacao="5" :travarPaginacao="false"
                                @retornaPaginacao="childRetornaPaginacao">
                            </Paginacao>
                        </div>


                    </div>
                </div>
                <div class="conteudo--mainContent__livro">
                    <div v-for="livro in dataSource.livros">
                        <LivroCard :dataSource="livro"></LivroCard>
                    </div>

                </div>

            </div>
            <div class="conteudo--rightBar">


            </div>


        </div>



    </div>
</template>
<style scoped>
@import "@/../sass/Paginainicial/paginainicial.scss";
</style>
