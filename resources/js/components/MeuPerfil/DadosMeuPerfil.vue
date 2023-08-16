<script lang="ts">
import { User } from "@/user";
import { MeuPerfilController } from "@/MeuPerfil/Controllers/meuperfilController";

const user = new User ;
const meuperfilController = new MeuPerfilController;
console.log(user.getUserId());
export default{

    data() {
        return {
            dados: user.getUserId(),
            meuperfil : meuperfilController.somar( 1 , 2 ),
        }
    }
}

</script>


<template>
    <h1>User {{ dados }}</h1>
    <h2>MeuPerfil {{ meuperfil }}</h2>
   </template>
