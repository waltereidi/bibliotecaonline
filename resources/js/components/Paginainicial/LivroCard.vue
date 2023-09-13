<script lang="ts">
import config from "@/../json/bibliotecaconfig.json";

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
    }

}

</script>
<template>
    <div class="mdc-card mdc-card--elevated">
        <div class="leftInfo">
            <div class="leftInfo--titulo">
                <h3>Titulo</h3>
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
                        <p>Download:</p><span><img :src="downloadIcon" v-if="dataSource.urldownload"></span>
                    </div>

                </div>
                <div v-if="dataSource.descricao" class="leftInfo--informacoes__right">
                    <p>{{ dataSource.descricao }}</p>
                </div>
            </div>
        </div>
        <div class="rightMedia">
            <img :src="dataSource.capalivro ?? configDataSource.capaLivroDefault" />
        </div>


    </div>
</template>

<style scoped>
@import "@/../sass/Paginainicial/livroCard.scss";
</style>
