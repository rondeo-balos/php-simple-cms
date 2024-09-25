<script setup>
import { useLayeredEffect } from '@/Pages/Partials/Layered';
import { ref } from 'vue';

defineProps([ 'srcBase', 'srcText', 'srcObj' ]);

const containerRef = ref(null);
const txtImageRef = ref(null);
const objImageRef = ref(null);

const { handleMouseMove, resetTransform } = useLayeredEffect(containerRef, txtImageRef, objImageRef);
</script>

<template>
  <div>
    <div class="relative rounded-lg overflow-hidden bg-black" @mousemove="handleMouseMove" @mouseleave="resetTransform" ref="containerRef">
        <img :src="srcBase" class="w-auto h-auto base-image pointer-events-none" />
        <img :src="srcText" class="w-auto h-auto absolute top-0 layer-image pointer-events-none" ref="txtImageRef" />
        <img :src="srcObj" class="w-auto h-auto absolute top-10 pointer-events-none layer-image" ref="objImageRef" />
    </div>
  </div>
</template>

<style scoped>
.layer-image {
  transition: transform 0.1s ease-out;
  will-change: transform;
}
</style>