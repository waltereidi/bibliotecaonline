<script lang="ts">
import LivroCard from "./LivroCard.vue";
import LivrosDataSource from "@/../json/livrosdoperfils.json";
import Paginacao from "@/components/Utils/Paginacao.vue";
export default {
    components: {
        LivroCard,
        Paginacao,
    },
    data() {
        return {
            dataSource: LivrosDataSource,
            searchBar: '',
            modal: false,
            indiceAtivo: 'Todos',
            indicesDataSource: {
                type: Object
            },

        }

    },

    methods: {
        buscar() {
        },
        getIndices() {
            return [
                {
                    "nomeIndice": "Todos",
                    "quantidade": 4,
                    "tipo": "todos"
                },
                {
                    "nomeIndice": "Ficção cientifica",
                    "quantidade": 3,
                    "tipo": "genero"
                },
                {
                    "nomeIndice": "Biografia",
                    "quantidade": 4,
                    "tipo": "genero"
                },
                {
                    "nomeIndice": "Tecnologia da informação do b",
                    "quantidade": 4,
                    "tipo": "genero"
                },
                {
                    "nomeIndice": "Românce",
                    "quantidade": 4,
                    "tipo": "genero"
                }

            ];



        },
        getIndicesMobile() {
            return [
                {
                    "nomeIndice": "Todos",
                    "quantidade": 4,
                    "tipo": "todos"
                },
                {
                    "nomeIndice": "Ficção cientifica",
                    "quantidade": 3,
                    "tipo": "genero"
                },
                {
                    "nomeIndice": "Biografia",
                    "quantidade": 4,
                    "tipo": "genero"
                },
                {
                    "nomeIndice": "Tecnologia da informação do b",
                    "quantidade": 4,
                    "tipo": "genero"
                },
                {
                    "nomeIndice": "Românce",
                    "quantidade": 4,
                    "tipo": "genero"
                }

            ];



        },

        getDataSourceIndices(nomeIndice: string, tipo: string) {
            this.indiceAtivo = nomeIndice;
        },
        childRetornaPaginacao(paginaAtual: number, multiplicador: number) {

        }
    },


}
</script>
<template>
    <div :class="{ 'container locked': lockScreen, 'container': !lockScreen }">
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

                <div v-for="indice in getIndicesMobile()"
                    :class="{ 'index ativo': indice.nomeIndice === indiceAtivo, 'index': indice.nomeIndice !== indiceAtivo }"
                    @click="getDataSourceIndices(indice.nomeIndice, indice.tipo, index)">
                    {{ indice.nomeIndice }}
                </div>




            </div>
        </div>
        <div class="conteudo">
            <div class="conteudo--leftBar">
                <div class="menuGrid header">
                    <h5>Indices</h5>
                </div>
                <div class="menuGrid">
                    <div v-for=" menuIndice  in   this.getIndices() ">
                        <div :class="{ 'menuContent': !(menuIndice.nomeIndice === indiceAtivo), 'menuContent ativo': (menuIndice.nomeIndice === indiceAtivo) }"
                            @click="getDataSourceIndices(menuIndice.nomeIndice, menuIndice.tipo)">
                            <p>{{ menuIndice.nomeIndice }}</p><em> {{ menuIndice.quantidade }}</em>
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
                            <Paginacao :multiplicador="8" :quantidade="35" :limitePaginacao="5" :travarPaginacao="false"
                                @retornaPaginacao="childRetornaPaginacao">
                            </Paginacao>
                        </div>


                    </div>
                </div>
                <div class="conteudo--mainContent__livro">
                    <div v-for="         livro          in          dataSource         ">
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
