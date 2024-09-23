<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AppHead from '@/Components/CustomComponents/AppHead.vue';
import TitleBar from '@/Components/CustomComponents/TitleBar.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps([ 'status', 'title', 'data', 'id' ]);

let form = useForm({
    name: props.data ? props.data.name : '',
    email: props.data ? props.data.email : '',
    password: '',
    password_confirmation: ''
});

const save = () => {
    form.post( route('user.create'), {
        preserveScroll: true,
        onError: (e) => console.log(e)
    });
};

const update = () => {
    form.patch( route('user.update', [props.id]), {
        preserveScroll: true,
        onError: (e) => {
            console.log(e);
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
            }
        }
    });
};

const updatePassword = () => {
    form.patch( route('user.update.password', [props.id]), {
        preserveScroll: true,
        onError: (e) => {
            console.log(e);
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
            }
        }
    });
}
</script>

<template>
    <AppHead :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <TitleBar :title="title" :back="true" />
        </template>

        <div class="py-2">
            <div class="sm:px-6 lg:px-8 space-y-6">
                <form @submit.prevent="" class="flex flex-col md:flex-row gap-6 gap-y-3">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex-grow">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Profile Information</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Account's profile information and email address.
                        </p>

                        <div class="mt-4">
                            <InputLabel for="name" value="Name" />
                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="email" value="Email" />
                            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="new-username" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div v-if="props.id" class="text-right">
                            <PrimaryButton @click.prevent="update" :disabled="form.processing" class="mt-4">Save</PrimaryButton>
                        </div>
                    </div>
                    
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex-grow">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ props.id ? 'Update' : '' }} Password</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Ensure you're using a long, random password to stay secure.
                        </p>

                        <div class="mt-4">
                            <InputLabel for="password" value="Password" />
                            <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password_confirmation" value="Confirm Password" />
                            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <div v-if="props.id" class="text-right">
                            <PrimaryButton @click.prevent="updatePassword" :disabled="form.processing" class="mt-4">Update</PrimaryButton>
                        </div>
                        <div v-else class="text-right">
                            <PrimaryButton @click.prevent="save" :disabled="form.processing" class="mt-4">Create</PrimaryButton>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>