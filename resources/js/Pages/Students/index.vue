<script setup>
import { Head, Link } from '@inertiajs/vue3';
defineProps({
    Students : Array,
});
</script>
<template>
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="container mt-4 ">
            <div class="">
                <div class="">
                    <div class="">
                        <table class="">
                            <thead class="">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody> <!--podria usarse vfor para crear la lista por ahora hago esta plantilla-->
                                <tr v-for=" student in Students" :Key="student.id">
                                    <td>{{ student.id }}</td>
                                    <td>{{ student.nombre }}</td>
                                    <td>
                                        <Link href="/about">
                                            Editar
                                        </Link>        
                                        <Link href="/about">
                                            Borrar
                                        </Link>     
                                        <Link href="/about">
                                            Ampliar
                                        </Link>     
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
