<script>


export default {
    props : ['authentication']
    ,
    data(){
        return {
         
        }
    }, 
    mounted(){
        console.log(this.authentication);
    }
}
</script>


<template>
    <h1>Dados do meu perfil {{ this.authentication }}</h1>
</template>