<script lang="ts">
import ModalImagem from "@/components/Utils/Modal/ModalImagem.vue";
import config from "@/../json/bibliotecaconfig.json";
import {ref} from 'vue';
import { PerfilUsuarioController } from "@/PerfilUsuario/perfilUsuarioController";
import Carregando from "../Utils/Carregando.vue";
export default {
    props:{
        datasource:{
            required:true ,
            type: Object ,
        }
    },
    data() {
        return {
            configDataSource: config,
            livrosDataSource: null,
            scroll: 0,
            perfilUsuarioController : ref(new PerfilUsuarioController(this.datasource.token_aplicativo)),
            offset : 0 ,
            carregando : false ,
            windowSize: window.innerWidth,
        }
    },
    components: {
        ModalImagem,
        Carregando,
    },
    methods:{
        handleScroll(event){
            if (((window.innerHeight + window.scrollY) >= document.body.offsetHeight)  &&
                (window.scrollY != this.scroll) &&
                ( this.offset < this.datasource.quantidadelivros))
                {
                    this.scroll =window.scrollY;
                    this.carregando = true ;
                    const url = this.perfilUsuarioController.getDadosPerfilUsuarioLivros(this.datasource.users_id , this.offset);
                    this.perfilUsuarioController.getPerfilusuarioLivros(url).then( (response) => {


                        if(response.status === 200 )
                        {
                            response.data.forEach( livro => {
                                this.livrosDataSource.push(livro);
                            });

                            this.offset += response.data.length;
                        }
                    }).finally(()=>{
                        this.carregando= false;
                    });
                }
        },
        acessarLivro(livros_id)
        {

            console.log(livros_id);
            window.location.href='/livros/'+livros_id;
        }
    },
    created(){
        window.addEventListener('scroll' , this.handleScroll);
        const url = this.perfilUsuarioController.getDadosPerfilUsuarioLivros(this.datasource.users_id , 0);
        this.perfilUsuarioController.getPerfilusuarioLivros(url).then( (response) => {
            if(response.status === 200 )
            {
                this.livrosDataSource = response.data ;
                this.offset += response.data.length;
            }
        });

    },
    unmounted(){
        window.removeEventListener('scroll' , this.handleScroll);
    }
}
</script>

<template>
    <Carregando :show="carregando"></Carregando>
    <div class="container">
        <div class="container--header">
            <div class="container--header__blackline">
                <h3>{{ datasource.users_nome }}</h3>
                <div class="containerProfilePicture">
                    <ModalImagem
                        :srcImagem="datasource.profile_picture ?? configDataSource.profile_pictureDefault">
                    </ModalImagem>
                </div>
            </div>
            <div class="container--header__headerbottom">
                <div class="scores">
                    <div class="scores--card">
                        <h4>{{ datasource.quantidadelivros }}</h4>
                        <p>Livros cadastrados</p>
                    </div>

                </div>

            </div>


        </div>
        <div class="container--conteudo">
            <h5>Introdução</h5>
            <p>{{ datasource.introducao }}</p>

        </div>
        <div class="container--containerLivros" v-if="windowSize > 460">

            <div v-for="livro in livrosDataSource" class="container--containerLivros__livro" >

                <div   class="capalivro">
                    <img :src="livro.capalivro ?? configDataSource.capaLivroDefault">
                </div>

                <a :href="'/livros/'+livro.id"><h5  class="titulo">{{ livro.titulo }}</h5></a>

                <p class="informacao">{{ livro.autores_nome }}</p>
            </div>

        </div>
        <div class="container--containerLivros" id="containerLivros" v-else>

            <div @click="acessarLivro(livro.id)" v-for="livro in livrosDataSource" class="container--containerLivros__livro">

                    <div class="capalivro" >
                        <img :src="livro.capalivro ?? configDataSource.capaLivroDefault">
                    </div>

                    <h5 class="titulo">{{ livro.titulo }}</h5>
                    <p class="informacao">{{ livro.autores_nome }}</p>


            </div>

        </div>

    </div>
</template>
<style scoped>
@import "@/../sass/PerfilUsuario/perfilUsuario.scss";
</style>
