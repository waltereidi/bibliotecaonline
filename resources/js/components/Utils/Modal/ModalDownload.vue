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
        if (/drive\.google/.test(this.urldownload)) {
            this.downloadIcon = 'icons\\icons8-google-drive.svg';
        } else if (/1drv\.ms/.test(this.urldownload)) {
            this.downloadIcon = 'icons\\icons8-onedrive.svg';
        } else if (/dropbox/.test(this.urldownload)) {
            this.downloadIcon = 'icons\\icons8-dropbox.svg';
        } else {
            this.downloadIcon = '';
        }
    }
}
</script>
<template>
    <button class="mdc-button mdc-button--outlined mdc-button--download" @click="abrirModal"
        v-if="(downloadIcon === '')">Visualizar link</button>
    <span v-else>
        <a :href="urldownload" target="_blank">
            <img :src="downloadIcon">
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
                <button @click="fecharModal" class="mdc-button mdc-button--outlined mdc-button--cancelar">
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
