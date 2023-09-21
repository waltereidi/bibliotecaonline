<script lang="ts">
import CKEditor from "@/components/Utils/CKEditor.vue";
import ModalImagem from "@/components/Utils/Modal/ModalImagem.vue";
import config from "@/../json/bibliotecaconfig.json";
import CardContainer from "@/components/MeuPerfil/CardGrid/CardContainer.vue";
export default {
    data() {

        return {
            configDataSource: config,
            dataSource: {
                type: Object,
                default: {
                    profile_picture: '',
                    datanascimento: '',
                    introducao: ''
                },
            },
        }
    },
    components: {
        ModalImagem,
        CardContainer


    }

}
</script>
<template>
    <div class="content">
        <div class="content--form">
            <div class="content--form__left">
                <div class="profile_picture">
                    <ModalImagem :srcImagem="configDataSource.profile_pictureDefault"></ModalImagem>
                </div>
            </div>
            <div class="content--form__right">
                <label class="mdc-text-field mdc-text-field--filled ">
                    <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                        <span class="mdc-text-field__ripple"></span>
                        <span class="mdc-floating-label mdc-floating-label--float-above">
                            Url da imagem do perfil
                        </span>
                        <input class="mdc-text-field__input" type="text" aria-label="profile_picture">
                        <span class="mdc-line-ripple"></span>
                    </label>
                </label>


                <label class="mdc-text-field mdc-text-field--filled ">
                    <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                        <span class="mdc-text-field__ripple"></span>
                        <span class="mdc-floating-label mdc-floating-label--float-above">
                            Data de nascimento
                        </span>
                        <input type="date" class="mdc-text-field__date datepicker" max="2013-12-31"
                            aria-label="datanascimento">
                        <span class="mdc-line-ripple"></span>
                    </label>
                </label>

                <label
                    class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--with-internal-counter">
                    <span class="mdc-notched-outline">
                        <span class="mdc-notched-outline__leading"></span>

                        <span class="mdc-notched-outline__trailing">Introdução do perfil</span>
                    </span>


                    <span class="mdc-text-field__resizer">
                        <textarea v-model="dataSource.introducao" class="mdc-text-field__input"
                            aria-labelledby="my-label-id" rows="5" maxlength="2048"></textarea>
                        <span class="mdc-text-field-character-counter" v-if="dataSource.introducao !== undefined">{{
                            dataSource.introducao.length }} /
                            2048</span>
                    </span>

                </label>
                <div class="actions">
                    <div class="actions--space">

                    </div>
                    <div class="actions--salvar">
                        <button class="mdc-button mdc-button--raised">Salvar</button>

                    </div>

                </div>

            </div>



        </div>
        <div class="content--livrosContainer">
            <CardContainer></CardContainer>
        </div>
    </div>
</template>
<style scoped>
@import "@/../sass/MeuPerfil/meuperfil.scss";
</style>
