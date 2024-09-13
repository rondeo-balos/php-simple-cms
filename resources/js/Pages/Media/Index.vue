<script setup>
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Upload from './Partials/Upload.vue';
import Modal from '@/Components/Modal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import DangerButton from '@/Components/DangerButton.vue';

// Icons
import Pen from '@/Icons/Pen.vue';
import Trash from '@/Icons/Trash.vue';

defineProps({
    'status': {
        type: String
    },
    'media': {
        type: Object
    }
});

const form = useForm({
    title: '',
    alt: ''
});

const ID = ref(null);
const URL = ref(null);

const closeModal = () => {
    ID.value = false;
    URL.value = null;
    form.reset();
};

const startEdit = (id, title, alt, url) => {
    ID.value = id;
    form.title = title;
    form.alt = alt;
    URL.value = url;
    console.log( url );
};

const saveEdit = () => {
    form.patch( route('media.update', ID.value), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: (e) => console.log(e)
    });
};

const deleteMedia = (id) => {
    let confirmation = confirm( 'Are you sure you want to delete this media?' );
    if( confirmation ) {
        form.delete( route('media.delete', id), {
            preserveScroll: true,
            onError: (e) => console.log(e)
        });
    }
};
</script>

<template>
    <Head title="Media" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row items-center">
                <div class="flex-grow">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Media</h2>
                </div>
                <Upload />
            </div>
        </template>

        <div class="py-2">
            <div class="sm:px-6 lg:px-8 space-y-6">
                <ul class="flex flex-row flex-wrap gap-2">
                    <li v-for="item in media" class="rounded-md overflow-hidden relative bg-white">
                        <img :src="'/storage/' + item.file" class="w-full h-auto object-cover sm:h-52 sm:w-52">
                        <div class="absolute w-full h-full flex flex-column bg-gray-900 bg-opacity-80 top-0 left-0 z-10 items-center justify-center gap-2 opacity-0 hover:opacity-100 transition-all">
                            <PrimaryButton @click="startEdit(item.id, item.title, item.alt, item.file)"><Pen class="w-5"/></PrimaryButton>
                            <DangerButton @click="deleteMedia(item.id)"><Trash class="w-5" /></DangerButton>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Edit Modal -->
        <Modal :show="ID" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                    Edit Media
                </h2>
                <form @submit.prevent="saveEdit">
                    <div class="mb-6">
                        <img v-if="URL" :src="'/storage/' + URL" class="w-full mt-4 object-cover h-96" />
                    </div>
                    <div class="mb-6">
                        <InputLabel for="title" value="Title" class="sr-only" />
                        <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" placeholder="Title" />
                        <InputError :message="form.errors.title" class="mt-2" />
                    </div>
                    <div class="mb-6">
                        <InputLabel for="alt" value="Alt Text" class="sr-only" />
                        <TextInput id="alt" v-model="form.alt" type="text" class="mt-1 block w-full" placeholder="Alt Text" />
                        <InputError :message="form.errors.alt" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal">Cancel</SecondaryButton>

                        <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" >Save</PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>