
<script lang="ts">
import { MeuPerfilController } from "@/MeuPerfil/Controllers/meuperfilController";
import { ApiRequest } from "@/Utils/apiRequest";
import { MensagensController } from "@/Mensagens/Controllers/mensagensController";
import { MensagensCaixa } from "@/Mensagens/Entidades/mensagensCaixa";
import { Mensagens } from "@/Mensagens/Entidades/mensagens";


const meuPerfilController = new MeuPerfilController;
//const getDadosMeuPerfil = meuPerfilController.getDadosMeuPerfil('sdsd');

const apiRequest = new ApiRequest;
let users: Users;
let status: number ;
const retorno =await apiRequest.getTestToken('testCase@email.com', 'testCase');
users = retorno.data;
status = retorno.status;
console.log(users);
console.log(status);
if ( users.api_token != null) {
    const meuPerfil = new MeuPerfilController(users.api_token);
    await meuPerfil.getDadosMeuPerfil().then(response => { console.log(response.data) });
    await meuPerfil.getLivrosMeuPerfil(202122).then(response => { console.log(response.data) });

    const mensagensController = new MensagensController(users.api_token);

    await mensagensController.getMensagensCaixa().then(response=> console.log( response.data ) );
}



</script>
<template>

<h1>TestPage</h1>
</template>
