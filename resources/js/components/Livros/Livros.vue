<script lang="ts">
import config from "@/../json/bibliotecaconfig.json";
import LivroDataSource from "@/../json/livroDataSource.json";
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
            livroDataSource: LivroDataSource,

        }
    },
    components: {
        ModalImagem,
        ModalDownload,

    }
}
</script>
<template>
    <div class="container">
        <div class="header">

        </div>
        <div class="mainContent">
            <div class="mainContent--left">
                <div class="mainContent--left__capalivro">
                    <ModalImagem :srcImagem="livroDataSource.capalivro ?? configDataSource.capaLivroDefault"></ModalImagem>
                </div>
            </div>
            <div class="mainContent--right">
                <div class="mainContent--right__titulo">
                    <h3> {{ livroDataSource.titulo }}

                    </h3>
                    <p><span v-if="livroDataSource.idioma.length > 0">Edição
                            {{ livroDataSource.idioma }}
                            <span class="pipeLineSeparator">|</span></span>Por
                        {{ livroDataSource.autores_nome }}

                    </p>
                    <hr>
                </div>
                <div class="mainContent--right__informacao">
                    <details v-if="livroDataSource.descricao.length > 400">

                        <summary>Leia mais...
                            <blockquote>
                                {{ livroDataSource.descricao.substring(0, 400) }}<span>...</span>
                            </blockquote>

                        </summary>
                        {{ livroDataSource.descricao }}
                    </details>

                    <blockquote v-else>
                        {{ livroDataSource.descricao }}
                    </blockquote>

                    <div class="containerInformacao border rounded">
                        <div class="containerInformacao--item">Autor
                            <div class="containerInformacao--itemDescricao">{{ livroDataSource.autores_nome }}</div>
                        </div>
                        <div class="containerInformacao--item">Editora
                            <div class="containerInformacao--itemDescricao">{{ livroDataSource.editoras_nome }}</div>
                        </div>
                        <div class="containerInformacao--item">ISBN
                            <div class="containerInformacao--itemDescricao">{{ livroDataSource.isbn }}</div>
                        </div>
                        <div class="containerInformacao--item">Gênero
                            <div class="containerInformacao--itemDescricao">{{ livroDataSource.genero }}</div>
                        </div>
                        <div class="containerInformacao--item-last">Idioma
                            <div class="containerInformacao--itemDescricao containerInformacao--itemDescricao__last">{{
                                livroDataSource.idioma }}</div>
                        </div>
                    </div>

                </div>
                <div class="download">
                    <div class="label">
                        Download:
                    </div>
                    <div class="icon">
                        <ModalDownload :urldownload="livroDataSource.urldownload"></ModalDownload>
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
