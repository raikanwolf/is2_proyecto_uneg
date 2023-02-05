<script setup>
import { ref } from "vue";
</script>

<template>
<div class="flex justify-center items-center bg-[url('/imgs/FONDOUNEG.jpg')] bg-cover bg-[length:100%_100%] h-[calc(100vh-64px)]">

    <div class="w-full max-w-xs">
  <form class="bg-[#202124] rounded px-8 pt-6 pb-8 mb-4">
    <img src="/imgs/LOGOUNEG.jpg" width="250" class="rounded-2xl"/>

    <div class="mb-4 mt-4">
      <label class="block text-white text-sm font-bold mb-2" for="username">
        Nombre de usuario
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username">
    </div>
    <div class="mb-6">
      <label class="block text-white text-sm font-bold mb-2" for="password">
        Contraseña
      </label>
      <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
      <p class="text-red-500 text-xs italic">Ingresar contraseña</p>
    </div>
    <div class="flex items-center justify-between">
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
        Iniciar
      </button>
      <div class="pr-20"/>
      <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
       Olvidaste la contraseña?
      </a>
    </div>
  </form>

</div>

</div>
</template>
