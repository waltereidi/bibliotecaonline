<script lang="ts">
import Card from "@/components/MeuPerfil/CardGrid/Card.vue";
import ModalFormularioAdicionar from "./Opcoes/ModalFormularioAdicionar.vue";
import Paginacao from "@/components/Utils/Paginacao.vue";
import Carregando from "@/components/Utils/Carregando.vue";
import Sucesso from "@/components/Utils/Sucesso.vue";
import {MeuPerfilController} from "@/MeuPerfil/meuperfilController";
import { ref } from 'vue/dist/vue.esm-bundler';


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
            sucesso : false ,
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
    },
    methods: {
        buscar() {

        },
        childRetornaPaginacao(paginacao, multiplicador) {


        },
        childModalAdicionarSucesso( retorno ){

            this.sucesso = true ;
            const dados  =this.meuperfilController.getDadosLivrosMeuPerfil({
                quantidade : 20 ,
                pagina : 0 ,
                meuperfil_id : this.datasourcemeuperfil.id
            });

            this.meuperfilController.postLivrosMeuPerfil(dados).then(result => {
                if(result.status === 200)
                {
                    console.log(result);
                    this.dataSource = result.data.livros ;
                    this.quantidadeLivros = result.data.quantidadeTotal ;
                }
            }
            );
            setTimeout(() => {
                this.sucesso = false ;
            },2000);

        }
    },



}
</script>
<template>
    <Sucesso :show="sucesso"></Sucesso>
    <div class="Container" >

        <div class="Container--cardGridHeader">

            <div class="Container--cardGridHeader__left">
                <Paginacao :quantidade="quantidadelivros" :multiplicador="6" :limitePaginacao="8" :travarPaginacao="false"
                    v-if="quantidadelivros>0"
                    @retornaPaginacao="childRetornaPaginacao"></Paginacao>
            </div>
            <div class="Container--cardGridHeader__right">
                <ModalFormularioAdicionar :api_token="api_token" :users_id="datasourcemeuperfil.users_id" @modalAdicionarSucesso="childModalAdicionarSucesso"></ModalFormularioAdicionar>
            </div>

        </div>
        <div class="Container--cardContainer">

            <div v-for="livro in dataSource" v-if="quantidadeLivros>6">
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
