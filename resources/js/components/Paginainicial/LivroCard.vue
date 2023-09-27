<script lang="ts">
import config from "@/../json/bibliotecaconfig.json";
import ModalImagem from "@/components/Utils/Modal/ModalImagem.vue";
import ModalDownload from "@/components/Utils/Modal/ModalDownload.vue";


export default {
    props: {
        dataSource: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            configDataSource: config,
            downloadIcon: '',
        }

    },
    mounted() {

    },
    components: {
        ModalImagem,
        ModalDownload,
    }

}

</script>
<template>
    <div class="mdc-card mdc-card--elevated">
        <div class="leftInfo">
            <div class="leftInfo--titulo">
                <h3><a :href="'/livros/' + dataSource.id">{{ dataSource.titulo }}</a></h3>
            </div>
            <div class="leftInfo--informacoes">
                <div class="leftInfo--informacoes__left">

                    <div v-if="dataSource.isbn" class="infoLivro">
                        <p>ISBN:</p><span>{{ dataSource.isbn }}</span>
                    </div>
                    <div class="infoLivro">
                        <p>Autor:</p><span>{{ dataSource.autores_nome }}</span>
                    </div>
                    <div class="infoLivro">
                        <p>Editora:</p><span>{{ dataSource.editoras_nome }}</span>
                    </div>
                    <div class="infoLivro" v-if="dataSource.genero">
                        <p>Gênero:</p><span>{{ dataSource.genero }}</span>
                    </div>
                    <div class="infoLivro" v-if="dataSource.idioma">
                        <p> Idioma:</p><span>{{ dataSource.idioma }}</span>
                    </div>
                    <div class="infoLivro">
                        <p>Doador:</p><span><a href="/perfilusuario">{{ dataSource.users_name }}</a></span>
                    </div>
                    <div class="infoLivro infoLivro--download" v-if="dataSource.urldownload">
                        <p>Download:</p>
                        <ModalDownload :urldownload="dataSource.urldownload"></ModalDownload>
                    </div>

                </div>
                <div v-if="dataSource.descricao" class="leftInfo--informacoes__right">
                    <p>{{ dataSource.descricao.substring(0, 600) + (dataSource.descricao.length > 600 ? '...' : '') }}</p>
                </div>
            </div>
        </div>
        <div class="rightMedia">
            <ModalImagem :srcImagem="dataSource.capalivro ?? configDataSource.capaLivroDefault"></ModalImagem>
        </div>


    </div>
</template>

<style >
@import "@/../sass/Paginainicial/livroCard.scss";
</style>
