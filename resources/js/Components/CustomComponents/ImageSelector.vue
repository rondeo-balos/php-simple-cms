<script setup>
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Image from '@/Icons/Image.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import axios from 'axios';

const model = defineModel({
    type: String,
    required: true,
});

const showMedia = ref(false);
const showModal = () => {
    showMedia.value = true;
    fetchMedia();
};
const closeModal = () => {
    showMedia.value = false;
};

const results = ref([]);
const fetchMedia = () => {
    try {
        axios.get( route('api.media'), { params: {} } )
            .then( (response) => {
                results.value = response.data;
            });
    } catch( error ) {
        console.error( 'Fetch failed:', error );
    }
};
</script>

<template>
    <div class="flex flex-row basis-full">
        <TextInput v-model="model" class="flex-grow me-2" />
        <SecondaryButton @click="showModal">
            <img v-if="model" :src="model" class="pointer-events-none max-h-5" />
            <Image v-else class="fill-white min-w-5"/>
        </SecondaryButton>
    </div>

    <Modal :show="showMedia" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                Select Media
            </h2>
            
            <ul v-if="results.length > 0" class="flex flex-row flex-wrap gap-3">
                <li v-for="item in results" class="w-1/2 sm:w-1/4">
                    <SecondaryButton class="rounded-none p-2 w-full" @click="model = `/storage/${item.file}`; showMedia = false;">
                        <img :src="'/storage/' + item.file" class="w-full h-auto object-cover sm:h-32 ">
                    </SecondaryButton>
                </li>
            </ul>
            <span v-else class="dark:text-white">No Media</span>
        </div>
    </Modal>
</template>