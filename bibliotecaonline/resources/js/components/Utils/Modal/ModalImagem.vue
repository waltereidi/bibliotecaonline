<script lang="ts">
export default {
    props: {
        srcImagem: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            showModal: false
        }
    },

    watch: {
        showModal() {
            if (this.showModal) {
                window.addEventListener('keydown', this.keyListener);
            }
        }
    },
    methods: {
        keyListener(event) {
            if (event.keyCode === 27 && this.showModal) {
                this.$store.commit('closeModal');
                this.showModal = false;
            }
        },
        fecharModal() {
            if (this.showModal) {
                this.$store.commit('closeModal');
                this.showModal = false;
            }

        },
        abrirModal() {
            this.$store.commit('openModal');
            this.showModal = true;
        }
    },

}
</script>
<template>
    <img class="cursor" :src="srcImagem" @click="abrirModal" loading="lazy" style="width: 100%;">
    <div :class="{ 'showModal': showModal, 'hide': !showModal }" @click="fecharModal">
        <div class="row">
            <button id="modalButton" type="button" class="btn-close btn-close-white" aria-label="Close"
                @click="fecharModal"></button>
            <img :src="srcImagem" loading="lazy" alt="capalivroModal" class="modalImage">

        </div>
    </div>
</template>
<style scoped>
.hide {
    display: none;
}

.cursor {
    cursor: pointer;
}

.showModal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Cor de fundo com transparência */
    z-index: 1000;
    /* Coloque um valor alto para sobrepor outros elementos */
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.modalImage {
    max-width: 95vw;
    max-height: 95vh;
}



#modalButton {
    margin-left: 100%;
}
</style>
