<script lang="ts">
import Card from "@/components/MeuPerfil/CardGrid/Card.vue";
import ModalFormularioAdicionar from "./Opcoes/ModalFormularioAdicionar.vue";
import Paginacao from "@/components/Utils/Paginacao.vue";
import Carregando from "@/components/Utils/Carregando.vue";
import Sucesso from "@/components/Utils/Sucesso.vue";
import {MeuPerfilController} from "@/MeuPerfil/meuperfilController";
import { ref } from 'vue/dist/vue.esm-bundler';
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
            erro : false ,
            sucesso : false ,
            loading : false,
            dataSource : this.datasourcelivros,
            meuperfilController : ref(new MeuPerfilController(this.api_token)),
            quantidadeLivros:this.quantidadelivros,
        }
    },
    components: {
        Card,
        ModalFormularioAdicionar,
        Paginacao,
        Carregando ,
        Sucesso ,
        Erro
    },
    methods: {
        buscar() {

        },
        childRetornaPaginacao(paginacao, multiplicador) {
            this.loading = true ;

            const dados  =this.meuperfilController.getDadosLivrosMeuPerfil({
                quantidade : multiplicador ,
                pagina : paginacao ,
                meuperfil_id : this.datasourcemeuperfil.id
            });


            this.meuperfilController.postLivrosMeuPerfil(dados).then(result => {
                if(result.status === 200)
                {
                    this.dataSource = result.data ;
                }

            }
            ).catch(()=>{
                this.erro = true;
                setTimeout(() => {
                this.erro = false ;
            },2000);
            }).finally(()=>{
                this.loading=false;
            });

        },
        async atualizarDataSource(){
            const dados  =this.meuperfilController.getDadosLivrosMeuPerfil({
                quantidade : 6 ,
                pagina : 0 ,
                meuperfil_id : this.datasourcemeuperfil.id
            });

            const urlGet = this.meuperfilController.getDadosGetMeuPerfilLivrosDoUsuarioQuantidade(this.datasourcemeuperfil.users_id);
            await this.meuperfilController.getMeuPerfilLivrosDoUsuarioQuantidade(urlGet).then((response) => {
                if(response.status === 200){
                    this.quantidadeLivros = null ;
                    this.quantidadeLivros = response.data;
                }
            }).catch(() => {
                this.erro = true;
                setTimeout(() => {
                this.erro = false ;
                },2000);
            });
            await this.meuperfilController.postLivrosMeuPerfil(dados).then(response => {
                if(response.status === 200)
                {
                    this.dataSource = response.data ;
                }
            });
        },
        childModalAdicionarSucesso( retorno ){

            this.sucesso = true ;

            this.atualizarDataSource();
            setTimeout(() => {
                this.sucesso = false ;
            },2000);

        },
        childModalEditarSucesso(retorno){
            this.sucesso = true ;

            this.meuperfilController.postLivrosMeuPerfil(dados).then(response => {
                if(response.status === 200)
                {
                    this.atualizarDataSource();
                }
            }
            );
            setTimeout(() => {
                this.sucesso = false ;
            },2000);

        },
        childConfirmarExcluir(id){
            this.sucesso = true ;
            const dados = this.meuperfilController.getDeleteLivros(id);
            this.meuperfilController.deleteLivros(dados).then(response =>{
                if(response.status == 200 )
                {
                   this.atualizarDataSource();
                }
            });
            setTimeout(() => {
                this.sucesso = false ;
            },2000);

        }
    }


}
</script>
<template>
    <Carregando :show="loading"></Carregando>
    <Sucesso :show="sucesso"></Sucesso>
    <div class="Container" >

        <div class="Container--cardGridHeader">

            <div class="Container--cardGridHeader__left">
                <Paginacao :quantidade="quantidadeLivros" :multiplicador="6" :limitePaginacao="8" :travarPaginacao="false"
                    v-if="quantidadeLivros>6 && quantidadeLivros!= null"
                    @retornaPaginacao="childRetornaPaginacao"></Paginacao>
            </div>
            <div class="Container--cardGridHeader__right">
                <ModalFormularioAdicionar :api_token="api_token" :users_id="datasourcemeuperfil.users_id" @modalAdicionarSucesso="childModalAdicionarSucesso"></ModalFormularioAdicionar>
            </div>

        </div>
        <div class="Container--cardContainer">

            <div v-for="livro in dataSource" v-if="quantidadeLivros>0">
                <Card :datasource="livro" :api_token="api_token"
                @modalEditarSucesso="childModalEditarSucesso"
                @confirmarExcluir="childConfirmarExcluir"
                ></Card>
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
