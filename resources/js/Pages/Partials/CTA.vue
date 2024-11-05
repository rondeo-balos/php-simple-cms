<script setup>
import { ref } from 'vue';
import { useLayeredEffect } from '@/Pages/Partials/Layered';

defineProps([ 'is' ]);

const rippleVisible = ref(false);
const rippleStyle = ref({});
const buttonRef = ref(null);
const txtRef = ref(null);

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

const { handleMouseMove, resetTransform } = useLayeredEffect(buttonRef, txtRef, null, 0);
</script>

<template>
    <component :is="is" @mouseover="createRipple" @mouseout="rippleVisible = false" @mousemove="handleMouseMove" @mouseleave="resetTransform" class="bg-[#0b58ca] hover:scale-105 transition-all overflow-hidden min-w-48 min-h-14 block font-medium text-xl group/button rounded-full shadow text-white" ref="buttonRef">
        <span v-if="rippleVisible" :style="rippleStyle" class="ripple z-0 absolute rounded-full pointer-events-none"></span>
        <span class="block relative z-10 group-hover/button:text-black pointer-events-none layer" ref="txtRef"><slot/></span>
    </component>
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
    .layer {
        transition: transform 0.1s ease-out;
        will-change: transform;
    }
</style>