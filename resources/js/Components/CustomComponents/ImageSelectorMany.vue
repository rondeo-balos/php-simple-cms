<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Checkbox from '@/Icons/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const model = defineModel({
    type: Array
});

onMounted(() => {
    if( !model.value ) {
        model.value = [];
    }
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

const toggleImageSelection = (image) => {
    const index = model.value.indexOf(image);
    if( index === -1 ) {
        model.value.push(image);
        return;
    }
    model.value.splice(index, 1);
}
</script>

<template>
    <div class="flex flex-row flex-nowrap overflow-x-auto gap-3">
        <img v-for="image in model" :src="image" class="pointer-events-none max-h-36 object-contain bg-slate-900 rounded-md mb-3" />
    </div>
    <div class="flex flex-row basis-full justify-end">
        <SecondaryButton @click="showModal">
            Select Images
        </SecondaryButton>
    </div>

    <Modal :show="showMedia" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                Select Media
            </h2>
            
            <ul v-if="results.length > 0" class="flex flex-row flex-wrap gap-3">
                <li v-for="item in results" class="w-1/2 sm:w-1/4">
                    <SecondaryButton class="relative rounded-none p-2 w-full" @click="toggleImageSelection(`/storage/${item.file}`)">
                        <Checkbox v-if="model.includes(`/storage/${item.file}`)" class="absolute text-white top-0 right-0 w-6" />
                        <img :src="'/storage/' + item.file" class="w-full h-auto object-cover sm:h-32 ">
                    </SecondaryButton>
                </li>
            </ul>
            <span v-else class="dark:text-white">No Media</span>

            <PrimaryButton @click="closeModal" class="ms-auto mt-6">Close</PrimaryButton>
        </div>
    </Modal>
</template>