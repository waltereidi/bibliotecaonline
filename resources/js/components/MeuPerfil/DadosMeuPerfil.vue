<script lang="ts">
import { User } from "@/User ";
let user = new User ;

console.log(user.getUserId());
export default{

    data() {
        return {
        dados : user.getUserId()
        }
    }
}

</script>


<template>
    <h1>User {{ dados }}</h1>

   </template>
