<script lang="ts">
import config from "@/../json/bibliotecaconfig.json";
import { useVuelidate } from '@vuelidate/core'
import { required, url, minLength } from '@vuelidate/validators'
import { ref } from 'vue/dist/vue.esm-bundler';
import { meuperfilStore } from "@/Store/meuperfilStore";
export default {
    setup() {
        return { v$: useVuelidate() }
    },

    data() {
        return {
            configDataSource: config,
            showModal:false ,
            meuperfilStore: meuperfilStore(),
            dataSource: {
                titulo: '',
                descricao: '',
                isbn: '',
                capalivro: '',
                urldownload: '',
                editoras_nome: '',
                autores_nome: '',
                idioma: '',
                genero: '',
                visibilidade : 1 ,
                users_id : 0 ,
            }
        }
    },
    validations() {
        return {
            dataSource: {
                titulo: { required, minLength: minLength(4) },
                capalivro: { url },
                urldownload: { url ,required},
                editoras_nome: { required, minLength: minLength(4) },
                autores_nome: { required, minLength: minLength(4) },
            }
        }
    },
    emits: ['modalAdicionarSucesso'],
    methods: {
        abrirModal() {
            this.$store.commit('openModal');
            this.showModal = true;

        },
        async enviarModalFormulario(){
            await meuperfilStore.postLivros(this.dataSource);


        },
        cancelarFormulario(): void {
            this.limparFormulario();
            this.$store.commit('closeModal');
            this.showModal = false;
        },
        limparFormulario(): void {
            this.dataSource = {
                titulo: '',
                descricao: '',
                isbn: '',
                capalivro: '',
                urldownload: '',
                editoras_nome: '',
                autores_nome: '',
                idioma: '',
                genero: ''
            };
        }
    },

}

</script>
<template>

    <button class="mdc-button mdc-card__action mdc-card__action--button mdc-button--adicionar" @click="abrirModal">
        Adicionar
    </button>
    <div :class="{ 'showModal': showModal, 'hide': !showModal }">
        <div class="containerModalFormulario">
            <div class="containerModalFormulario--left">

                <img v-if="!v$.dataSource.capalivro.$invalid" class="rounded mx-auto d-block" :src="(dataSource.capalivro !==null && dataSource.capalivro.length>0) ? dataSource.capalivro : configDataSource.capaLivroDefault" />

            </div>
            <div class="containerModalFormulario--right">
                <!-- Input -->
                <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                    <span class="mdc-text-field__ripple"></span>
                    <span class="mdc-floating-label mdc-floating-label--float-above">
                        <span
                            :class="{ 'errorLabel': v$.dataSource.titulo.$invalid, '': !v$.dataSource.titulo.$invalid }">Titulo</span>
                    </span>
                    <input v-model="dataSource.titulo" class="mdc-text-field__input" type="text"
                        aria-labelledby="my-label-id" maxlength="60">
                    <span class="mdc-line-ripple"></span>
                    <div class="mdc-text-field-helper-line">

                        <div class="mdc-text-field-character-counter" v-if="dataSource.titulo.length > 0">{{
                            dataSource.titulo.length }} /
                            60
                        </div>
                        <div class="mdc-text-field-character-counter" v-else>
                            <span class="errorLabel">Campo obrigatório</span>
                        </div>
                    </div>
                </label>
                <!-- Input -->
                <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                    <span class="mdc-text-field__ripple"></span>
                    <span class="mdc-floating-label mdc-floating-label--float-above">
                        ISBN
                    </span>
                    <input v-model="dataSource.isbn" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id"
                        maxlength="20">
                    <span class="mdc-line-ripple"></span>
                    <div class="mdc-text-field-helper-line">
                        <div class="mdc-text-field-character-counter">{{ dataSource.isbn.length }} /
                            20
                        </div>
                    </div>
                </label>

                <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                    <span class="mdc-text-field__ripple"></span>
                    <span class="mdc-floating-label mdc-floating-label--float-above">
                        <span
                            :class="{ 'errorLabel': v$.dataSource.autores_nome.$invalid, '': !v$.dataSource.autores_nome.$invalid }">Nome
                            do autor</span>
                    </span>
                    <input v-model="dataSource.autores_nome" class="mdc-text-field__input" type="text"
                        aria-labelledby="my-label-id" maxlength="60">
                    <span class="mdc-line-ripple"></span>
                    <div class="mdc-text-field-helper-line">
                        <div class="mdc-text-field-character-counter" v-if="dataSource.autores_nome.length > 0">{{
                            dataSource.autores_nome.length
                        }} /
                            60
                        </div>
                        <div class="mdc-text-field-character-counter" v-else>
                            <span class="errorLabel">Campo obrigatório</span>
                        </div>
                    </div>
                </label>
                <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                    <span class="mdc-text-field__ripple"></span>
                    <span class="mdc-floating-label mdc-floating-label--float-above">
                        <span
                            :class="{ 'errorLabel': v$.dataSource.editoras_nome.$invalid, '': !v$.dataSource.editoras_nome.$invalid }">Nome
                            da editora</span>
                    </span>
                    <input v-model="dataSource.editoras_nome" class="mdc-text-field__input" type="text"
                        aria-labelledby="my-label-id" maxlength="60">
                    <span class="mdc-line-ripple"></span>
                    <div class="mdc-text-field-helper-line">
                        <div class="mdc-text-field-character-counter" v-if="dataSource.editoras_nome.length">{{
                            dataSource.editoras_nome.length
                        }} /
                            60
                        </div>
                        <div class="mdc-text-field-character-counter " v-else>
                            <span class="errorLabel">Campo obrigatório</span>
                        </div>
                    </div>
                </label>
                <!-- Input -->
                <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                    <span class="mdc-text-field__ripple"></span>
                    <span class="mdc-floating-label mdc-floating-label--float-above">
                        <span
                            :class="{ 'errorLabel': v$.dataSource.capalivro.$invalid, '': !v$.dataSource.capalivro.$invalid }">Url
                            da imagem da capa do livro</span>
                    </span>
                    <input v-model="dataSource.capalivro" class="mdc-text-field__input" type="text"
                        aria-labelledby="my-label-id" maxlength="2048">
                    <span class="mdc-line-ripple"></span>
                    <div class="mdc-text-field-helper-line">
                        <div class="mdc-text-field-character-counter"><span v-if="v$.dataSource.capalivro.$invalid"
                                class="errorLabel">Url
                                inválida</span>
                        </div>
                    </div>
                </label>

                <!-- Input -->
                <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                    <span class="mdc-text-field__ripple"></span>
                    <span class="mdc-floating-label mdc-floating-label--float-above">
                        <span
                            :class="{ 'errorLabel': v$.dataSource.urldownload.$invalid, '': !v$.dataSource.urldownload.$invalid }">Url
                            para download</span>
                    </span>
                    <input v-model="dataSource.urldownload" class="mdc-text-field__input" type="text"
                        aria-labelledby="my-label-id" maxlength="2048">
                    <span class="mdc-line-ripple"></span>
                    <div class="mdc-text-field-helper-line">
                        <div class="mdc-text-field-character-counter"><span v-if="v$.dataSource.urldownload.$invalid"
                                class="errorLabel">{{ (v$.dataSource.urldownload.$invalid &&
                                    (dataSource.urldownload !== undefined) && dataSource.urldownload !== '') ? 'Url inválida' :
                                    'url de download deve ser preenchida'
                                }}</span>
                        </div>
                    </div>
                </label>



                <!-- Input -->
                <div class="containerModalFormulario--right__doubledInputRow">


                    <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                        <span class="mdc-text-field__ripple"></span>
                        <span class="mdc-floating-label mdc-floating-label--float-above">
                            Gênero do livro
                        </span>
                        <input v-model="dataSource.genero" class="mdc-text-field__input" type="text"
                            aria-labelledby="my-label-id" maxlength="30">
                        <span class="mdc-line-ripple"></span>
                        <div class="mdc-text-field-helper-line">
                            <div class="mdc-text-field-character-counter">
                                {{ dataSource.genero.length }} / 30
                            </div>
                        </div>
                    </label>


                    <!-- Input -->
                    <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                        <span class="mdc-text-field__ripple"></span>
                        <span class="mdc-floating-label mdc-floating-label--float-above">
                            Idioma do livro
                        </span>
                        <input v-model="dataSource.idioma" class="mdc-text-field__input" type="text"
                            aria-labelledby="my-label-id" maxlength="30">
                        <span class="mdc-line-ripple"></span>
                        <div class="mdc-text-field-helper-line">
                            <div class="mdc-text-field-character-counter">
                                {{ dataSource.idioma.length }} / 30
                            </div>
                        </div>
                    </label>
                </div>
                <label
                    class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--with-internal-counter">
                    <span class="mdc-notched-outline">
                        <span class="mdc-notched-outline__leading"></span>
                        <span class="mdc-notched-outline__notch">
                            <span v-if="dataSource.descricao.length == 0"
                                class="mdc-floating-label mdc-floating-label--float-above"><br>Descrição
                                do livro</span>
                        </span>
                        <span class="mdc-notched-outline__trailing"></span>
                    </span>

                    <span class="mdc-text-field__resizer">
                        <textarea v-model="dataSource.descricao" class="mdc-text-field__input" aria-labelledby="my-label-id"
                            rows="5" cols="222" maxlength="2048"></textarea>
                        <span class="mdc-text-field-character-counter">{{ dataSource.descricao.length }} /
                            2048</span>
                    </span>
                </label>

            </div>
            <div class="containerModalFormulario--actions">
                <div class="cancelar">
                    <button @click="cancelarFormulario()" class="mdc-button mdc-button--cancelar">Cancelar
                    </button>
                </div>

                <div class="confirmar">
                    <button @click="enviarModalFormulario()" :disabled="v$.dataSource.$invalid"
                        class="mdc-button mdc-button--confirmar">Confirmar
                    </button>
                </div>
            </div>


        </div>

    </div>
</template>
<style scoped>
@import 'material-icons/iconfont/material-icons.css';
@import "@/../sass/MeuPerfil/CardGrid/Modal/modalFormulario.scss";

.mdc-button {
    margin-top: 0.3em;
    margin-right: 1em;

}
</style>
