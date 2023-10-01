<script lang="ts">
import config from "@/../json/bibliotecaconfig.json";
import ModalImagem from "@/components/Utils/Modal/ModalImagem.vue";
import ModalDownload from "@/components/Utils/Modal/ModalDownload.vue";
export default {
    props: {
        datasource: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            configDataSource: config,

        }
    },
    components: {
        ModalImagem,
        ModalDownload,

    },

}
</script>
<template>
    <div class="container">
        <div class="header">

        </div>
        <div class="mainContent">
            <div class="mainContent--left">
                <div class="mainContent--left__capalivro">
                    <ModalImagem :srcImagem="datasource.capalivro ?? configDataSource.capaLivroDefault"></ModalImagem>
                </div>
            </div>
            <div class="mainContent--right">
                <div class="mainContent--right__titulo">
                    <h3> {{ datasource.titulo }}

                    </h3>
                    <p><span v-if="datasource.idioma">Edição
                            {{ datasource.idioma }}
                            <span class="pipeLineSeparator">|</span></span>Por
                        {{ datasource.autores_nome }}
                        <span class="pipeLineSeparator">|</span>Doador: <a
                            :href="'/perfilusuario/' + datasource.users_id">{{ datasource.users_nome }}</a>

                    </p>
                    <hr>
                </div>
                <div class="mainContent--right__informacao">
                    <details v-if="datasource.descricao.length > 400">

                        <summary>Leia mais...
                            <blockquote>
                                {{ datasource.descricao.substring(0, 400) }}<span>...</span>
                            </blockquote>

                        </summary>
                        {{ datasource.descricao }}
                    </details>

                    <blockquote v-else>
                        {{ datasource.descricao }}
                    </blockquote>

                    <div class="containerInformacao border rounded">
                        <div class="containerInformacao--item">Autor
                            <div class="containerInformacao--itemDescricao">{{ datasource.autores_nome }}</div>
                        </div>
                        <div class="containerInformacao--item">Editora
                            <div class="containerInformacao--itemDescricao">{{ datasource.editoras_nome }}</div>
                        </div>
                        <div class="containerInformacao--item">ISBN
                            <div class="containerInformacao--itemDescricao">{{ datasource.isbn }}</div>
                        </div>
                        <div class="containerInformacao--item">Gênero
                            <div class="containerInformacao--itemDescricao">{{ datasource.genero }}</div>
                        </div>
                        <div class="containerInformacao--item-last">Idioma
                            <div class="containerInformacao--itemDescricao containerInformacao--itemDescricao__last">{{
                                datasource.idioma }}</div>
                        </div>
                    </div>

                </div>
                <div class="download">
                    <div class="label">
                        Download:
                    </div>
                    <div class="icon">
                        <ModalDownload :urldownload="datasource.urldownload"></ModalDownload>
                    </div>
                </div>

            </div>



        </div>
        <div class="footer">
        </div>
    </div>
</template>
<style scoped>
@import "@/../sass/Livros/livros.scss";
</style>
