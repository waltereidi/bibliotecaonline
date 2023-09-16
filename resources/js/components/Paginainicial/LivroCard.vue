<script lang="ts">
import config from "@/../json/bibliotecaconfig.json";
import ModalImagem from "@/components/Utils/ModalImagem.vue";

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
        if (/drive\.google/.test(this.dataSource.urldownload)) {
            this.downloadIcon = 'icons\\icons8-google-drive.svg';
        } else if (/1drv\.ms/.test(this.dataSource.urldownload)) {
            this.downloadIcon = 'icons\\icons8-onedrive.svg';
        } else if (/dropbox/.test(this.dataSource.urldownload)) {
            this.downloadIcon = 'icons\\icons8-dropbox.svg';
        } else {
            this.downloadIcon = '';
        }
    },
    components: {
        ModalImagem,
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
                    <div class="infoLivro" v-if="dataSource.urldownload">
                        <p>Download:</p><span><a :href="dataSource.urldownload" target="_blank">
                                <img :src="downloadIcon" v-if="dataSource.urldownload">
                                <p v-else>{{ dataSource.urldownload }}</p>
                            </a>

                        </span>
                    </div>

                </div>
                <div v-if="dataSource.descricao" class="leftInfo--informacoes__right">
                    <p>{{ dataSource.descricao }}</p>
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
