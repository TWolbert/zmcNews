<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import {reactive} from "vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    profile_picture: null as File | null,
});

const pfpUrl = reactive({
    value: '',
});

const fileError = reactive({
    value: ''
});

const submit = () => {
    const formData = new FormData();
    formData.append('file', (form.profile_picture as unknown as Blob));

    window.zestApi.post('/upload', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        const id = response.data.id;

        window.axios.post('/register', {
            name: form.name,
            email: form.email,
            password: form.password,
            password_confirmation: form.password_confirmation,
            pfp_id: id
        }).then(res => {
            window.location.href = '/';
        }).catch((error) => {
            form.errors = error.response.data.errors;
        });
    }).catch((error) => {
        console.log(error.response.data);
        fileError.value = error.response.data.message
    });
};

const handleFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement
    if (target && target.files !== null && target.files.length > 0) {
        form.profile_picture = target.files[0];
        // Set the profile picture URL
        pfpUrl.value = URL.createObjectURL(form.profile_picture);
    }
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <input
                    type="file"
                    v-on:change="handleFileChange"
                    class="mt-1 block w-full"
                    required />

                <InputError class="mt-2" :message="fileError.value" />
            </div>

<!--            Render pfp-->
            <div class="mt-4">
                <img :src="pfpUrl.value" alt="Profile Picture" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
