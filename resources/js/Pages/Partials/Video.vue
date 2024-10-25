<script setup>
import { PlayCircleIcon } from '@heroicons/vue/24/outline';
import { useLayeredEffect } from '@/Pages/Partials/Layered';
import { ref } from 'vue';

defineProps([ 'cdn' ]);

const video = ref(null);
const videoPlayed = ref(false);
const playVideo = () => {
    if( video.value && !videoPlayed.value ) {
        videoPlayed.value = true;
        video.value.currentTime = 0;
        video.value.muted = false;
        video.value.loop = false;
        video.value.controls = true;
        video.value.play();
    }
};
const videoContainer = ref(null);
const playRef = ref(null);
/*const { handleMouseMove, resetTransform } = useLayeredEffect( videoContainer, playRef, null, 0, 30 );*/
</script>

<template>
    <div class="relative w-full shadow-2xl rounded-3xl overflow-hidden group transition-all">
        <video :class="[ { 'fixed left-0 top-0' : videoPlayed }, 'w-full h-auto cursor-pointer transition-all z-30' ]" :poster="`${cdn}poster.gif`" autoplay muted loop ref="video" @click="playVideo">
            <source src="https://dl.dropboxusercontent.com/scl/fi/38l16oiq47hohnbja799l/hello-world.mp4?rlkey=jnc3x4g1vp2hv9v8g5c8wa5li&st=dkyuz4uj&dl=0" type="video/mp4">
        </video>
        <div v-if="!videoPlayed" class="group-hover:opacity-100 opacity-100 transition-opacity duration-300 absolute left-0 top-0 w-full h-full bg-black bg-opacity-80 flex items-center justify-center cursor-pointer" @click="playVideo" @mousemove="handleMouseMove" @mouseleave="resetTransform" ref="videoContainer">
            <PlayCircleIcon class="rounded-full w-1/5 h-1/5 group-hover:scale-125 transition-transform" ref="playRef" />
        </div>
    </div>
</template>

