<script lang="ts">
import { ref } from 'vue/dist/vue.esm-bundler';
import LivroCard from "./LivroCard.vue";
import Paginacao from "@/components/Utils/Paginacao.vue";
import { PaginainicialController } from "@/Paginainicial/paginainicialController";
import Carregando from "@/components/Utils/Carregando.vue";
import Erro from "@/components/Utils/Erro.vue";
import Alerta from '../Utils/Alerta.vue';
import Sucesso from '../Utils/Sucesso.vue';
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
        Erro,
        Alerta ,
        Sucesso,

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
            mensagemErro: false,
            mensagemAlerta:false,
            exibirPaginacao:true ,
            mensagemSucesso:{
                mensagem :'' ,
                sucesso : false ,
            },
            searchBar: '',
            modal: false,
            indiceAtivo:{ 'indice':'Todos' ,'tipo':'Todos'},
            indicesDataSource: [] as {
                indice: string,
                quantidade: number,
                tipo: string,
            }[],
            paginainicialController : ref(new PaginainicialController(this.token_aplicativo)),
        }
    },
    methods: {
        async buscar()
        {
            if(this.searchBar.length <2 )
            {
                return ;
            }
            this.exibirPaginacao=false;
            this.travarPaginacao = true ;

            const dados = this.paginainicialController.getDadosBuscaRequest(this.searchBar);
            const retorno =await this.paginainicialController.postBusca(dados);
            if(retorno.status === 204)
            {
                this.popAlerta();
            }else{
                if(retorno.status === 200)
                {
                    this.mensagemSucesso.mensagem=retorno.data['quantidadeTotal']+' livros encontrado'+((retorno.data['quantidadeTotal']>1)?'s':'') ;
                    this.popSucesso();
                    this.dataSource = retorno.data;

                }
            }

            this.travarPaginacao=false;


        },
        popSucesso(){
            this.mensagemSucesso.sucesso=true ;
            setTimeout(()=>{
                this.mensagemSucesso.sucesso=false;
            },5000);
        },
        popAlerta(){

            this.mensagemAlerta = true ;
            setTimeout(()=>{
                this.mensagemAlerta=false ;
            },5000);
        },
        childRetornaPaginacao(paginaAtual: number, multiplicador: number) {
            if(this.indiceAtivo){
                this.travarPaginacao = true;



                const dados =this.paginainicialController.getDadosBuscaIndice(multiplicador, (paginaAtual*multiplicador) , [this.indiceAtivo]);
                const dadosRequest = this.paginainicialController.getDadosBuscaIndiceRequest(dados);

                const buscaIndicePromise = new Promise(async (resolve) =>{
                    await resolve(this.paginainicialController.postBuscaIndice(dadosRequest));
                });
                buscaIndicePromise.then((resolve) => {
                    this.dataSource = resolve.data;
                    this.travarPaginacao = false ;
                })
            }
        },
    },
    created() {
        this.paginainicialController.getIndices().then(response => {
            this.indicesDataSource = response.data;
        }
        );
        const dados =this.paginainicialController.getDadosBuscaIndice(20, 0 , [{'tipo':'todos' , 'indice':'Todos'}]);
        const dadosRequest = this.paginainicialController.getDadosBuscaIndiceRequest(dados);
        this.paginainicialController.postBuscaIndice(dadosRequest).then(response =>{
            this.dataSource = response.data;
        });
    },
    watch:{
        indiceAtivo(newVal){
            if(!this.travarPaginacao)
                this.travarPaginacao=true;
                this.exibirPaginacao=true;

                this.dataSource.quantidadeTotal= null ;

                const dados =this.paginainicialController.getDadosBuscaIndice(20, 0 , [this.indiceAtivo] );
                const dadosRequest = this.paginainicialController.getDadosBuscaIndiceRequest(dados);

                const buscaIndicePromise = new Promise(async (resolve) =>{
                    await resolve(this.paginainicialController.postBuscaIndice(dadosRequest));
                });
                buscaIndicePromise.then((resolve) => {

                    this.dataSource = resolve.data;
                    this.travarPaginacao = false ;
                })
    }

}
}
</script>
<template>
     <Carregando :show="travarPaginacao"></Carregando>
     <Erro :show="mensagemErro"></Erro>
     <Alerta :show="mensagemAlerta"></Alerta>
     <Sucesso :show="mensagemSucesso.sucesso" :mensagem="mensagemSucesso.mensagem"></Sucesso>
    <div class="container">
        <div class="header">
            <img :src="'/imagens/wallpaper.jpg'" />
        </div>
        <div class="headerDivisory">
            <div class="searchBar">

                <label class="mdc-text-field mdc-text-field--filled mdc-text-field--with-trailing-icon">
                    <span class="mdc-floating-label" id="my-label-id" v-if="searchBar === ''">Procurar</span>
                    <input @keyup.enter="buscar" v-model="searchBar" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id">
                    <i @click="buscar" class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing"
                        tabindex="0" role="button">search</i>
                </label>

            </div>
            <div class="indexBar">

                <div v-for="menu in indicesDataSource"
                    :class="{ 'index ativo': ( menu.indice== indiceAtivo.indice && menu.tipo == indiceAtivo.tipo), 'index':  !( menu.indice== indiceAtivo.indice && menu.tipo == indiceAtivo.tipo) }"
                    @click="indiceAtivo ={'indice':menu.indice, 'tipo':menu.tipo}">
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
                            @click="indiceAtivo ={'indice':menu.indice, 'tipo':menu.tipo}">
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
                            <Paginacao :multiplicador="20" :quantidade="dataSource.quantidadeTotal" :limitePaginacao="5" :travarPaginacao="travarPaginacao" v-if="dataSource.quantidadeTotal!=null && exibirPaginacao"
                                @retornaPaginacao="childRetornaPaginacao">
                            </Paginacao>
                        </div>
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


        </div>



    </div>
</template>
<style scoped>
@import "@/../sass/Paginainicial/paginainicial.scss";
</style>
