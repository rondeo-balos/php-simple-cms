<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const upload = ref(false);
const url = ref(null);
const file = ref(null);

const form = useForm({
    title: '',
    alt: '',
    file: null
});

const showUploadModal = () => {
    upload.value = true;
};

const closeModal = () => {
    upload.value = false;

    form.reset();
    url.value = null;
};

const previewFile = (e) => {
    file.value = e.target.files[0];
    url.value = URL.createObjectURL( file.value );
};

const uploadFile = () => {
    if( typeof file !== 'undefined' ) {
        form.file = file.value;
    }
    form.post( route('media.create'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: (e) => console.log(e)
    });

};
</script>

<template>
    <PrimaryButton @click="showUploadModal">Add Media</PrimaryButton>

    <Modal :show="upload" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                    Add Media
                </h2>
                <form @submit.prevent="uploadFile">
                    <div class="mb-6">
                        <InputLabel for="file" value="File Upload" class="sr-only" />
                        <input id="file" type="file" :ref="file" @change="previewFile" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" />
                        <img v-if="url" :src="url" class="w-full mt-4 max-h-80 object-contain object-center bg-gray-900" />
                        <InputError :message="form.errors.file" class="mt-2" />
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
                        <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                        <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" >Upload</PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
</template>