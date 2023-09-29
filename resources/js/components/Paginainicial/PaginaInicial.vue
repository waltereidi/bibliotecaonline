<script lang="ts">
import LivroCard from "./LivroCard.vue";
import Paginacao from "@/components/Utils/Paginacao.vue";
import { PaginainicialController } from "@/Paginainicial/paginainicialController";
import Carregando from "@/components/Utils/Carregando.vue";

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
        Carregando,
    },
    data() {
        return {
            dataSource: {
                type : {
                    livros: {type:Object , required:true },
                    quantidadeTotal : {type:Number , required:true},
                },

            },
            travarPaginacao : false ,
            searchBar: '',
            modal: false,
            indiceAtivo:{ 'indice':'Todos' ,'tipo':'todos'},
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
            if(!this.travarPaginacao)
            this.indiceAtivo = {'indice':nomeIndice ,'tipo': tipo};
            this.travarPaginacao=true;

            const paginainicialController = new PaginainicialController(this.token_aplicativo);
            const dados =paginainicialController.getDadosBuscaIndice(20, 0 , [this.indiceAtivo] );
            const dadosRequest = paginainicialController.getDadosBuscaIndiceRequest(dados);
            paginainicialController.postBuscaIndice(dadosRequest).then(response =>{
                this.dataSource = response.data;
            this.travarPaginacao=false;
        }).catch( (error) => {
            this.travarPaginacao=false;
            this.dataSource.livros= null ;
            this.dataSource.quantidadeTotal=0;
        });
        },
        childRetornaPaginacao(paginaAtual: number, multiplicador: number) {
            if(this.indiceAtivo){
                this.travarPaginacao = true;
                const paginainicialController = new PaginainicialController(this.token_aplicativo);
                const dados =paginainicialController.getDadosBuscaIndice(multiplicador, (paginaAtual*multiplicador) , [{'tipo':'Todos' , 'indice':'todos'}]);
                const dadosRequest = paginainicialController.getDadosBuscaIndiceRequest(dados);
                paginainicialController.postBuscaIndice(dadosRequest).then(response =>{
                this.dataSource = response.data;
                this.travarPaginacao=false;
        });
            }
        },
    },
    beforeCreate() {
        const paginainicialController = new PaginainicialController(this.token_aplicativo);
        paginainicialController.getIndices().then(response => {
            this.indicesDataSource = response.data;
        }
        );
        const dados =paginainicialController.getDadosBuscaIndice(20, 0 , [{'tipo':'todos' , 'indice':'Todos'}]);
        const dadosRequest = paginainicialController.getDadosBuscaIndiceRequest(dados);
        paginainicialController.postBuscaIndice(dadosRequest).then(response =>{
            this.dataSource = response.data;
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
                    :class="{ 'index ativo': ( menu.indice== indiceAtivo.indice && menu.tipo == indiceAtivo.tipo), 'index':  !( menu.indice== indiceAtivo.indice && menu.tipo == indiceAtivo.tipo) }"
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
                        <div :class="{ 'menuContent': ! ( menu.indice== indiceAtivo.indice && menu.tipo == indiceAtivo.tipo), 'menuContent ativo': ( menu.indice== indiceAtivo.indice && menu.tipo == indiceAtivo.tipo) }"
                            @click="getDataSourceIndices(menu.indice, menu.tipo)">
                            <p>{{ (menu.indice.length > 22) ? (menu.indice.substring(0, 22)) + '...' : menu.indice }}</p>
                            <em>{{ menu.quantidade }}</em>
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
                            <Paginacao :multiplicador="20" :quantidade="dataSource.quantidadeTotal" :limitePaginacao="5" :travarPaginacao="travarPaginacao" v-if="dataSource.quantidadeTotal"
                                @retornaPaginacao="childRetornaPaginacao">
                            </Paginacao>
                        </div>
                        {{ dataSource.quantidadeTotal }}

                    </div>
                </div>
                <div class="conteudo--mainContent__livro">
                    <div v-if="dataSource.livros" v-for="livro in dataSource.livros">
                        <LivroCard :dataSource="livro"></LivroCard>
                    </div>

                </div>

            </div>
            <div class="conteudo--rightBar">


            </div>

            <Carregando :carregando="travarPaginacao"></Carregando>
        </div>



    </div>
</template>
<style scoped>
@import "@/../sass/Paginainicial/paginainicial.scss";
</style>
