<script lang="ts">
import ModalImagem from "@/components/Utils/Modal/ModalImagem.vue";
import config from "@/../json/bibliotecaconfig.json";
import CardContainer from "@/components/MeuPerfil/CardGrid/CardContainer.vue";
import { MeuPerfilController } from "@/MeuPerfil/meuperfilController";
import Carregando from "../Utils/Carregando.vue";
export default {
    props:{
        api_token:{
            required : true ,
            type:String ,
        },
        datasourcelivros: {
            required:true ,
            type:Object ,
        },
        datasourcemeuperfil : {
            required : true ,
            type:Object
        },
        quantidadelivros : {
            required : true ,
            type : Object ,
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
            loading : false ,
        }
    },
    components: {
        ModalImagem,
        CardContainer,
        Carregando,
    },
    methods:{
        salvar(){
            const meuperfilController= new MeuPerfilController(this.api_token);
            const dados = meuperfilController.getPutMeuPerfil(this.dataSource);

            const retorno = meuperfilController.putMeuPerfil(dados).then( response=>{
                console.log(response);
            });

        }
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
                        <input class="mdc-text-field__input" v-model="dataSource.profile_picture" type="text" aria-label="profile_picture">
                        <span class="mdc-line-ripple"></span>
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
                        <button :disabled="loading" @click="salvar" class="mdc-button mdc-button--raised">Salvar</button>
                    </div>
                </div>
                <Carregando :show="loading"></Carregando>
            </div>



        </div>
        <div class="content--livrosContainer">
            <CardContainer :datasource="datasourcelivros" :quantidadelivros="quantidadelivros"></CardContainer>
        </div>
    </div>
</template>
<style scoped>
@import "@/../sass/MeuPerfil/meuperfil.scss";
</style>
