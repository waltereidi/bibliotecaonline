<script lang="ts">
export default {
    props: {
        urldownload: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            showModal: false,
            downloadIcon: '',
            labelButton: '',
        }
    },
    methods: {
        fecharModal() {
            if (this.showModal) {
                this.$store.commit('closeModal');
                this.showModal = false;
            }

        },
        abrirModal() {
            this.$store.commit('openModal');
            this.showModal = true;
        },
    },

    mounted() {
        if (/drive.google/.test(this.urldownload)) {
            this.downloadIcon = '\\icons\\icons8-google-drive.svg';
            this.labelButton='Google drive';
        } else if (/1drv\.ms/.test(this.urldownload)) {
            this.downloadIcon = '\\icons\\icons8-onedrive.svg';
            this.labelButton='One drive';
        } else if (/dropbox/.test(this.urldownload)) {
            this.downloadIcon = '\\icons\\icons8-dropbox.svg';
            this.labelButton='Drop box';
        } else {
            this.downloadIcon = '';
            this.labelButton='';
        }
    }
}
</script>
<template>
    <button class="mdc-button mdc-button--outlined mdc-button--download" @click="abrirModal"
        v-if="(downloadIcon === '')">Visualizar link</button>
    <span v-else>
        <a :href="urldownload" target="_blank">
            <button class="download-button">
                <img class="download-button--icon" :src="downloadIcon"><span>{{ labelButton }}</span>
            </button>
        </a>
    </span>

    <div :class="{ 'showModal': showModal, 'hide': !showModal }">
        <div class="modalDownload">
            <div class="modalDownload--header">
                <h5>Revisar link</h5>
            </div>
            <div class="modalDownload--content">
                <p class="modalDownload--content__message">Este link não possui repositório de compartilhamento confiável
                    como <strong>GoogleDrive , OneDrive ou DropBox</strong> ,verifique sua origem antes de fazer o download.
                </p>
                <p class="modalDownload--content__link">{{ urldownload }}</p>
            </div>
            <div class="modalDownload--buttons">
                <button @click="fecharModal" class="mdc-button mdc-button--cancelar">
                    Cancelar
                </button>
                <a :href="urldownload" target="_blank">
                    <button class="mdc-button mdc-button--download">
                        Download
                    </button>
                </a>
            </div>

        </div>


    </div>
</template>
<style scoped>
@import "@/../sass/Utils/Modal/modalContainer.scss";
</style>
