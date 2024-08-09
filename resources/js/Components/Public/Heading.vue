<script setup>
defineProps({
    content: {
        type: String,
        default: 'Cool Heading'
    },
    type: {
        type: String,
        default: 'h2'
    }
});
</script>

<template>
    <component :is="type" class="text-black dark:text-gray-400 text-7xl">{{ content }}</component>
</template>