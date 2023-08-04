<script>

export default{
    props :['nome' , 'url', 'icon'],
}
</script>
<style scoped>

</style>
<template>

    <div class="container">
        <img :src="this.icon" >
        
        <div class="container-interno">
            
            <h2>Resetar senha</h2>
            <br>
            <p>Você esqueceu sua senha e deseja reseta-la<br>
            utilize o link abaixo.</p>
            <div class="botao-reset">
                <button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button>
            </div>
            <br>
            <br>
            <p><small>Se você não solicitou o reset de senha , pode ignorar este email.<br>
            Apenas a pessoa com acesso a seu email pode resetar sua senha.
            </small></p>

        </div>

        
    </div>


</template>