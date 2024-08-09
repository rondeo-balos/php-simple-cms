<script setup>
defineProps({
    content: {
        type: String,
        default: 'This is a paragraph text'
    }
});
</script>

<template>
    <p class=" text-black dark:text-gray-400">{{ content }}</p>
</template>