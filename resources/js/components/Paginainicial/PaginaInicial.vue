<script lang="ts">
import LivroCard from "./LivroCard.vue";
import LivrosDataSource from "@/../json/livrosdoperfils.json";

export default {
    components: {
        LivroCard,
    },
    data() {
        return {
            dataSource: LivrosDataSource,
            searchBar: '',
        }

    },

    methods: {
        buscar() {

        }
    }

}
</script>
<template>
    <div class="container">
        <div class="header">
            <img :src="'/imagens/wallpaper.jpg'" />
        </div>
        <div class="headerDivisory">
            <div class="searchBar">

                <label class="mdc-text-field mdc-text-field--filled mdc-text-field--with-trailing-icon">
                    <span class="mdc-floating-label" id="my-label-id" v-if="searchBar === ''">Procurar</span>
                    <input v-model="searchBar" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id">
                    <i @click="buscar" class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing"
                        tabindex="0" role="button">search</i>
                </label>

            </div>
            <div class="indexBar">

            </div>
        </div>
        <div class="conteudo">
            <div class="conteudo--leftBar">
                <div class="menuGrid header">
                    <h5>Indices</h5>
                </div>
                <div class="menuGrid">Gênero</div>
                <div class="menuGrid">Idioma</div>



            </div>
            <div class="conteudo--mainContent">
                <div class="conteudo--mainContent__livro">
                    <div v-for=" livro  in  dataSource ">
                        <LivroCard :dataSource="livro"></LivroCard>
                    </div>

                </div>

            </div>
            <div class="conteudo--rightBar">


            </div>


        </div>



    </div>
</template>
<style scoped>
@import "@/../sass/Paginainicial/paginainicial.scss";
</style>
