<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    id: '',
    profession: '',
    date_admission: '',
    professor_type: '',
});

const submit = () => {
    form.post(route('professors.store'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Professor Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="id" value="ID" />

                <TextInput
                    id="id"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.id"
                    required
                    autofocus
                    autocomplete="id"
                />

                <InputError class="mt-2" :message="form.errors.id" />
            </div>

            <div>
                <InputLabel for="profession" value="Profession" />

                <TextInput
                    id="profession"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.profession"
                    required
                    autocomplete="profession"
                />

                <InputError class="mt-2" :message="form.errors.profession" />
            </div>

            <div class="mt-4">
                <InputLabel for="date_admission" value="Date admission" />

                <TextInput
                    id="date_admission"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.date_admission"
                    required
                    autocomplete="date_admission"
                />

                <InputError class="mt-2" :message="form.errors.date_admission" />
            </div>

            <div class="mt-4">
                <InputLabel for="professor_type" value="Professor type" />

                <TextInput
                    id="professor_type"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.professor_type"
                    required
                    autocomplete="professor_type"
                />

                <InputError class="mt-2" :message="form.errors.professor_type" />
            </div>

            <div class="flex items-center justify-end mt-4">

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
