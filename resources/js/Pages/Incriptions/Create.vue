<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({

    name: '{{nombre_asignaturas[0].course_type}}',
    email: '',
  
});

const submit = () => {
    form.post(route('incriptions.store'));
};

</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            

            <div class="mt-4">
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <input type="text" value="nombre_asignaturas[0].course_type}}" v-model="form.email" class="mt-1 block w-full"/>

            <div class="flex items-center justify-end mt-4">

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
<script>
export default{
    props: ["nombre_asignaturas"],
    components: {
        GuestLayout,
    },
};
</script>