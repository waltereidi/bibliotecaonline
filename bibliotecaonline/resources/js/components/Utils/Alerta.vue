<script lang="ts">
    export default{
        props:{
            show : {
                required:true ,
                type:Boolean
            }
        }
    }
</script>
<template>
    <div v-if="show" class="alerta">
        <p>Nenhum livro encontrado</p>
    </div>
</template>
<style scoped>
    .alerta{
        background-color:#FFF176;
        opacity: 80%;
        height: 3em;
        width:50%;
        padding-top:1em;
        padding-left:1em;
        padding-right:1em;
        display:flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        border-radius: 5px;
        position: fixed;
        bottom:5em;
        left:25%;
        color: #607D8B;
        font-weight: bold;
        z-index: 10000;
    }
</style>
