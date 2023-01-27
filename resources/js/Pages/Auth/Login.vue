<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="flex justify-center items-center bg-[url('/imgs/FONDOUNEG.jpg')] bg-cover bg-[length:100%_100%] h-[calc(100vh-64px)]">
        <Head title="Log in" />
        
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600 ">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="bg-[#202124] rounded px-8 pt-6 pb-8 mb-4">
            <img src="/imgs/LOGOUNEG.jpg" width="250" class="rounded-2xl"/>
            <div>
                <InputLabel for="email" value="Email" class="block text-white text-sm font-bold mb-2" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Contraseña" class="block text-white text-sm font-bold mb-2" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-200 ">Recuerdame</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <PrimaryButton class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Iniciar
                </PrimaryButton>
                
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#"
                >
                    Olvidó la contraseña?
                </Link>

                
            </div>
        </form>
    </div>
</template>
