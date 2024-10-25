<script setup>
import { PlayCircleIcon } from '@heroicons/vue/24/outline';
import { useLayeredEffect } from '@/Pages/Partials/Layered';
import { ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';

defineProps([ 'cdn' ]);

const video = ref(null);
const videoPlayed = ref(false);
const playVideo = () => {
    videoPlayed.value = true;
};

const stopVideo = () => {
    videoPlayed.value = false;
}
const videoContainer = ref(null);
const playRef = ref(null);
/*const { handleMouseMove, resetTransform } = useLayeredEffect( videoContainer, playRef, null, 0, 30 );*/
</script>

<template>
    <div class="relative w-full shadow-2xl rounded-3xl overflow-hidden group transition-all">
        <video class="w-full h-auto cursor-pointer transition-all z-30" :poster="`${cdn}poster.gif`" autoplay muted loop @click="playVideo">
            <source src="https://dl.dropboxusercontent.com/scl/fi/38l16oiq47hohnbja799l/hello-world.mp4?rlkey=jnc3x4g1vp2hv9v8g5c8wa5li&st=dkyuz4uj&dl=0" type="video/mp4">
        </video>
        <div v-if="!videoPlayed" class="group-hover:opacity-100 opacity-100 transition-opacity duration-300 absolute left-0 top-0 w-full h-full bg-black bg-opacity-80 flex items-center justify-center cursor-pointer" @click="playVideo" @mousemove="handleMouseMove" @mouseleave="resetTransform" ref="videoContainer">
            <PlayCircleIcon class="rounded-full w-1/5 h-1/5 group-hover:scale-125 transition-transform" ref="playRef" />
        </div>
    </div>
    <Modal :show="videoPlayed" @close="stopVideo" maxWidth="full">
        <div class="h-[90vh] flex items-center">
            <video class="w-full h-auto cursor-pointer transition-all z-30 rounded-2xl" :poster="`${cdn}poster.gif`" autoplay controls>
                <source src="https://dl.dropboxusercontent.com/scl/fi/38l16oiq47hohnbja799l/hello-world.mp4?rlkey=jnc3x4g1vp2hv9v8g5c8wa5li&st=dkyuz4uj&dl=0" type="video/mp4">
            </video>
        </div>
    </Modal>
    
</template>

