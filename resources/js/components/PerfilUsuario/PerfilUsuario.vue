<script lang="ts">
import MeuPerfilDataSource from "@/../json/meuperfildatasource.json";
import LivrosDoPerfil from "@/../json/livrosdoperfils.json";
import ModalImagem from "@/components/Utils/Modal/ModalImagem.vue";
import config from "@/../json/bibliotecaconfig.json";
export default {
    props:{
        datasource:{
            required:true ,
            type: Object ,
        }
    },
    data() {
        return {
            meuPerfilDataSource: MeuPerfilDataSource,
            configDataSource: config,
            livrosDataSource: LivrosDoPerfil,
            windowSize: window.innerWidth,
        }
    },
    components: {
        ModalImagem,
    },
    mounted(){
        console.log(this.datasource);
    }
}
</script>

<template>
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
            <div v-for="livro in livrosDataSource" class="container--containerLivros__livro">
                <div class="capalivro">
                    <img :src="livro.capalivro ?? configDataSource.capaLivroDefault">
                </div>

                <h5 class="titulo"><a :href="'livros/' + livro.id">{{ livro.titulo }}</a></h5>
                <p class="informacao">{{ livro.autores_nome }}</p>
            </div>

        </div>
        <div class="container--containerLivros" v-else>

            <div v-for="livro in livrosDataSource" class="container--containerLivros__livro">
                <a :href="'livros/' + livro.id">
                    <div class="capalivro">
                        <img :src="livro.capalivro ?? configDataSource.capaLivroDefault">
                    </div>

                    <h5 class="titulo">{{ livro.titulo }}</h5>
                    <p class="informacao">{{ livro.autores_nome }}</p>
                </a>

            </div>

        </div>

    </div>
</template>
<style scoped>
@import "@/../sass/PerfilUsuario/perfilUsuario.scss";
</style>
