<script setup>
import { ref, watch } from 'vue';
import { PlayIcon } from '@heroicons/vue/16/solid';
import Modal from '@/Components/Modal.vue';
import CTA from '@/Pages/Partials/CTA.vue';

defineProps([ 'cdn' ]);

const video = ref(null);
const videoPlayed = ref(false);
const playVideo = () => {
    videoPlayed.value = true;
    setTimeout(()=> video.value.play(), 100 );
};

const stopVideo = () => {
    videoPlayed.value = false;
    video.value.pause();
    video.value.currentTime = 0;
}
</script>

<template>
    <CTA @click="playVideo" is="button" class="min-w-42">Showreel <PlayIcon class="w-6 inline -mt-1" /></CTA>
    <Modal :show="videoPlayed" @close="stopVideo" maxWidth="full">
        <div class="h-[90vh] flex items-center">
            <video class="w-full h-auto cursor-pointer transition-all z-30 rounded-2xl" :poster="`${cdn}poster.gif`" controls ref="video">
                <source src="https://dl.dropboxusercontent.com/scl/fi/38l16oiq47hohnbja799l/hello-world.mp4?rlkey=jnc3x4g1vp2hv9v8g5c8wa5li&st=dkyuz4uj&dl=0" type="video/mp4">
            </video>
        </div>
    </Modal>
    
</template>

