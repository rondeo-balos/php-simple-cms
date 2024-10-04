<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const marquee = ref(null);
const content = ref(null);
const animationId = ref(null);
const offset = ref(0);
const speed = 0.5; // The speed of the marquee movement
const isPaused = ref(false);

// Function to move the marquee
const animateMarquee = () => {
  if (isPaused.value) return;
  
  offset.value -= speed;

  if (content.value && marquee.value) {
    const contentWidth = content.value.offsetWidth;
    const marqueeWidth = marquee.value.offsetWidth;

    // Reset the position of the marquee content when it's fully out of view
    if (offset.value <= -contentWidth) {
      offset.value = 0;
    }
  }

  // Continue the animation
  animationId.value = requestAnimationFrame(animateMarquee);

  console.log( 'marqueeing', offset.value );
};

// Pause the marquee on hover
const pauseMarquee = () => {
  isPaused.value = true;
  cancelAnimationFrame(animationId.value);
};

// Resume the marquee after hover
const resumeMarquee = () => {
  isPaused.value = false;
  animationId.value = requestAnimationFrame(animateMarquee);
};

onMounted(() => {
  // Start the marquee animation when the component is mounted
  animationId.value = requestAnimationFrame(animateMarquee);
});

onUnmounted(() => {
  // Clean up the animation frame when the component is unmounted
  cancelAnimationFrame(animationId.value);
});
</script>

<template>
    <div class="overflow-hidden whitespace-nowrap flex w-full relative gap-5 py-5" @mouseover="pauseMarquee" @mouseleave="resumeMarquee" ref="marquee">
        <div class="flex shrink-0 gap-5 text-sm md:text-base" ref="content" :style="{ transform: `translateX(${offset}px)` }">
            <slot />
        </div>
        <div class="flex shrink-0 gap-5" :style="{ transform: `translateX(${offset}px)` }">
            <slot />
        </div>
    </div>
</template>