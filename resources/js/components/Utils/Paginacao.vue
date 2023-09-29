<script lang="ts">
export default {
    props: {
        quantidade: Number,
        multiplicador: Number,
        limitePaginacao: Number,
        travarPaginacao: Boolean,

    },
    data() {
        return {
            arrayPaginas: [],
            paginacaoAtual: 1,
            ativarPaginacao: true,
        }
    },
    emits: ['retornaPaginacao'],
    methods: {
        retornaPaginacao(pagina) {
            if (!this.travarPaginacao) {
                this.paginacaoAtual = pagina;
                this.$emit('retornaPaginacao', this.paginacaoAtual, this.multiplicador);
            }
        },
        proximaPagina() {
            if (!this.travarPaginacao) {
                this.paginacaoAtual = this.paginacaoAtual < this.arrayPaginas.length ? this.paginacaoAtual + 1 : this.paginacaoAtual;
                this.retornaPaginacao(this.paginacaoAtual);
            }
        },
        voltarPagina() {
            if (!this.travarPaginacao) {
                this.paginacaoAtual = this.paginacaoAtual > 1 ? this.paginacaoAtual - 1 : this.paginacaoAtual;
                this.retornaPaginacao(this.paginacaoAtual);
            }
        }
    },
    beforeMount() {
        this.arrayPaginas = [];
        for (var i = 1, k = 1; (i* this.multiplicador) < this.quantidade; i ++, k++) {
            this.arrayPaginas.push(k);
        }

    },
    computed: {
        seletorPaginas(): Array {
            let contagem: number = (this.limitePaginacao < 2) ? 2 : this.limitePaginacao;
            const limitePaginacao: number = contagem;

            let retornoPaginas = [];
            for (var i = 0; i < this.arrayPaginas.length && contagem > 0; i++) {
                if (limitePaginacao >= this.arrayPaginas.length) {
                    retornoPaginas.push(this.arrayPaginas[i]);
                }
                else if (limitePaginacao < this.arrayPaginas.length) {
                    if (this.arrayPaginas[i] === 1 || this.arrayPaginas[i] === this.arrayPaginas.length || this.arrayPaginas[i] === this.paginacaoAtual) {
                        contagem--;
                        retornoPaginas.push(this.arrayPaginas[i]);
                    } else if (
                        ((this.arrayPaginas[i] > this.paginacaoAtual) && this.arrayPaginas[i] < (this.paginacaoAtual + (limitePaginacao / 2)))
                        ||
                        ((this.arrayPaginas[i] < this.paginacaoAtual) && this.arrayPaginas[i] > (this.paginacaoAtual - (limitePaginacao / 2)))
                    ) {
                        contagem--;
                        retornoPaginas.push(this.arrayPaginas[i]);
                    }
                }


            }
            retornoPaginas[0] = 1;
            retornoPaginas[retornoPaginas.length - 1] = this.arrayPaginas.length;
            return retornoPaginas;
        }
    }
}
</script>
<template>
    <nav class="paginacao">
        <ul class="pagination pagination-sm">
            <li class="page-item" v-if="quantidade > multiplicador">
                <a class="page-link" @click="voltarPagina" aria-label="Previous">
                    Anterior
                </a>
            </li>
            <div v-for="pagina in seletorPaginas">
                <li v-if="paginacaoAtual == pagina" @click="retornaPaginacao(pagina)" class="page-item active pagenumber">
                    <span class="page-link">
                        {{ pagina }}

                    </span>
                </li>
                <li class="page-item pagenumber" @click="retornaPaginacao(pagina)" v-else>
                    <a class="page-link">{{ pagina }}</a>
                </li>
            </div>

            <li class="page-item" v-if="quantidade > multiplicador">
                <a class="page-link" @click="proximaPagina" aria-label="Next">
                    Próximo
                </a>
            </li>
        </ul>
    </nav>
</template>
<style scoped>
.borderless {
    border: 0;
}

@media(min-width:320px) and (max-width:460px) {
    .pagenumber {
        display: none;
    }
}
</style>
