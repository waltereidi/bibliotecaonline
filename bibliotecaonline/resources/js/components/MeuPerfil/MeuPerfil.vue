<script lang="ts">
import ModalImagem from "@/components/Utils/Modal/ModalImagem.vue";
import config from "@/../json/bibliotecaconfig.json";
import CardContainer from "@/components/MeuPerfil/CardGrid/CardContainer.vue";
import { useVuelidate } from '@vuelidate/core';
import { required, url } from '@vuelidate/validators';
import Carregando from "@/components/Utils/Carregando.vue";
import Sucesso from "@/components/Utils/Sucesso.vue";
import Alerta from"@/components/Utils/Alerta.vue";
import Erro from '@/components/Utils/Erro.vue';
import { meuperfilStore } from "@/Store/meuperfilStore";

export default {
    setup(){
        return { v$ : useVuelidate() }
    },
    props:{
        api_token:{
            required : true ,
            type:String ,
        },
        datasourcelivros: {
            required:false ,
            type:Object ,
        },
        datasourcemeuperfil : {
            required : true ,
            type:Object
        },
        quantidadelivros : {
            required : true ,
            type : Number ,
        }
    },
    data() {
        return {
            configDataSource: config,
            dataSource: {
                    profile_picture: this.datasourcemeuperfil['profile_picture'] ?? '',
                    datanascimento: this.datasourcemeuperfil['datanascimento'] ?? '',
                    introducao: this.datasourcemeuperfil['introducao'] ?? '',
                    id : this.datasourcemeuperfil['id'],
                    users_id : this.datasourcemeuperfil['users_id'],
            },
            meuperfilStore : meuperfilStore(),
        }
    },
    validations(){
        return {
            dataSource : {
                    profile_picture : { url } ,
                    id : { required },
                    users_id : { required },
            }
        }
    },
    components: {
        ModalImagem,
        CardContainer,
        Carregando,
        Sucesso ,
        Alerta ,
        Erro ,
    },
    methods:{

        salvar(){
            this.meuperfilStore.putMeuPerfil(this.dataSource);
        }
    },
    beforeMount(){
        this.meuperfilStore.setUser(this.datasourcemeuperfil , this.api_token , this.quantidadelivros , this.datasourcelivros);
    }

}
</script>
<template>
    <Carregando :show="meuperfilStore.messages.carregando"></Carregando>
    <Sucesso :show="meuperfilStore.messages.sucesso"></Sucesso>
    <Erro :show="meuperfilStore.messages.erro"></Erro>
    <Alerta :show="meuperfilStore.messages.alerta"></Alerta>


    <div class="content">
        <div class="content--form">
            <div class="content--form__left">
                <div class="profile_picture">
                    <ModalImagem
                        :srcImagem="(v$.dataSource.profile_picture.$invalid || dataSource.profile_picture==='' || dataSource.profile_picture ===null )
                        ? configDataSource.profile_pictureDefault : dataSource.profile_picture">
                    </ModalImagem>
                </div>
            </div>
            <div class="content--form__right">
                <label class="mdc-text-field mdc-text-field--filled ">
                    <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                        <span class="mdc-text-field__ripple"></span>
                        <span class="mdc-floating-label mdc-floating-label--float-above">
                            <span
                            :class="{ 'errorLabel': v$.dataSource.profile_picture.$invalid, '': !v$.dataSource.profile_picture.$invalid }">Url da imagem do perfil</span>
                        </span>
                        <input class="mdc-text-field__input" v-model="dataSource.profile_picture" type="text" aria-label="profile_picture">
                        <span class="mdc-line-ripple"></span>
                        <span class="mdc-text-field-character-counter label-erro" >
                            <span v-if="v$.dataSource.profile_picture.$invalid"
                                class="errorLabel">Url
                                inválida</span></span>
                    </label>
                </label>


                <label class="mdc-text-field mdc-text-field--filled ">
                    <label class="mdc-text-field mdc-text-field--filled mdc-text-field--label-floating">
                        <span class="mdc-text-field__ripple"></span>
                        <span class="mdc-floating-label mdc-floating-label--float-above">
                            Data de nascimento
                        </span>
                        <input type="date" v-model="dataSource.datanascimento" class="mdc-text-field__date datepicker"
                            aria-label="datanascimento"  min="1937-01-01" max="2015-12-31" >
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
                        <button :disabled="(meuperfilStore.messages.carregando || meuperfilStore.messages.sucesso || v$.dataSource.$invalid)" @click="salvar" class="mdc-button mdc-button--raised">Salvar</button>
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
