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
    <div v-if="show" class="erro">
        <p>Erro ao processar a busca</p>
    </div>
</template>
<style scoped>
    .erro{
        background-color:#F44336;
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
        color:white;
        font-weight: bold;

    }
</style>
