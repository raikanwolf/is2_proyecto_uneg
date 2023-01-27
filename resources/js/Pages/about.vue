<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
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
                                    <th>Unidad Curricular</th>
                                    <th>Profesor/a</th>
                                    <th>Alumnos</th>
                                    <th>Seccion</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody> <!--podria usarse vfor para crear la lista por ahora hago esta plantilla-->
                                <tr class="">
                                    <td>Matematicas 2</td>
                                    <td>Mate Maticos</td>
                                    <td>12</td>
                                    <td>1</td>
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
