<script lang="ts">
import MeuPerfilDataSource from "@/../json/meuperfildatasource.json";
import LivroPerfilUsuario from "@/components/PerfilUsuario/LivrosPerfilUsuario.vue";
import ModalImagem from "@/components/Utils/Modal/ModalImagem.vue";
import config from "@/../json/bibliotecaconfig.json";
export default {
    data() {
        return {
            meuPerfilDataSource: MeuPerfilDataSource,
            configDataSource: config,
        }
    },
    components: {
        LivroPerfilUsuario,
        ModalImagem,
    }
}
</script>

<template>
    <div class="container">
        <div class="container--header">
            <div class="container--header__blackline">
                <h3>{{ meuPerfilDataSource.nome }}</h3>
                <div class="containerProfilePicture">
                    <ModalImagem
                        :srcImagem="meuPerfilDataSource.profile_picture ?? configDataSource.profile_pictureDefault">
                    </ModalImagem>
                </div>
            </div>
            <div class="container--header__headerbottom">
                <div class="scores">
                    <div class="scores--card">
                        <h4>15</h4>
                        <p>Livros cadastrados</p>
                    </div>
                    <div class="scores--card">
                        <h4>3</h4>
                        <p>Ticaracatica</p>
                    </div>
                </div>

            </div>


        </div>
        <div class="container--conteudo">
            <h5>Introdução</h5>
            <p>{{ meuPerfilDataSource.introducao }}</p>

        </div>
        <div class="container--containerLivros">


        </div>

    </div>
</template>
<style scoped>
@import "@/../sass/PerfilUsuario/perfilUsuario.scss";
</style>
