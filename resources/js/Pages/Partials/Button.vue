<script setup>
import { ref } from 'vue';

const props = defineProps([ 'button' ]);

const rippleVisible = ref(false);
const rippleStyle = ref({});
const buttonRef = ref(null);

const createRipple = (event) => {
    if( rippleVisible.value ) return;
    const button  = buttonRef.value;
    const rect = button.getBoundingClientRect();
    const diameter = Math.max(rect.width, rect.height);
    const radius = diameter / 2;

    const left = event.offsetX - radius;
    const top = event.offsetY - radius;

    // Set the style dynamically
    rippleStyle.value = {
    width: `${diameter}px`,
    height: `${diameter}px`,
    left: `${left}px`,
    top: `${top}px`,
    };

    // Show the ripple
    rippleVisible.value = true;
};
</script>

<template>
    <button v-if="button" @mouseover="createRipple" @mouseout="rippleVisible = false" class="bg-[#0b58ca] transition-all hover:scale-110 duration-500 px-5 py-3 font-bold text-white rounded-lg shadow table mx-auto overflow-hidden relative group/button" ref="buttonRef">
        <span v-if="rippleVisible" :style="rippleStyle" class="ripple z-0 absolute rounded-full pointer-events-none"></span>
        <span class="relative z-10 pointer-events-none group-hover/button:text-black group-hover/button:fill-black"><slot /></span>
    </button>
    <a v-else @mouseover="createRipple" @mouseout="rippleVisible = false" class="bg-[#0b58ca] transition-all hover:scale-110 duration-500 px-5 py-3 font-bold text-white rounded-lg shadow table mx-auto overflow-hidden relative group/button" ref="buttonRef">
        <span v-if="rippleVisible" :style="rippleStyle" class="ripple z-0 absolute rounded-full pointer-events-none"></span>
        <span class="relative z-10 pointer-events-none group-hover/button:text-black group-hover/button:fill-black"><slot /></span>
    </a>
</template>

<style scoped>
    .ripple {
        background-color: #fff;
        transform: scale(0);
        animation: ripple-animation 0.4s linear forwards;
    }
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 1;
        }
    }
</style>