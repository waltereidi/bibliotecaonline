
<script lang="ts">
import { MeuPerfilController } from "@/MeuPerfil/Controllers/meuperfilController";
import { ApiRequest } from "@/Utils/apiRequest";
import { loadConfigFromFile } from "vite";
import { AutomaticPrefetchPlugin } from "webpack";

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
</script>
<template>

<h1>TestPage</h1>
</template>
