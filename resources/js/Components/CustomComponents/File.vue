<script setup>
defineProps(['src']);
</script>

<template>
    <div class="border-4 border-dashed border-spacing-8 relative">
        <input type="file" class="w-full h-96 opacity-0" />
        <img v-if="src" :src="src" class="w-full h-full absolute top-0 left-0 object-contain object-center bg-gray-900 pointer-events-none" />
        <span v-else class="w-full text-center absolute left-0 mt-48 pointer-events-none dark:text-white">Click or Drag Media</span>
    </div>
</template>