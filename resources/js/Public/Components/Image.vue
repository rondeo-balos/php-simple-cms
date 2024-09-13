<script setup>
defineProps({
    src: {
        type: String,
        default: 'https://placehold.co/600x400'
    },
    alt: {
        type: String,
        default: 'Placeholder Image'
    }
});

defineOptions({
    meta: {
        src: {
            control: 'image'
        },
        alt: {
            control: 'text'
        }
    }
});
</script>

<template>
    <img :src="src" :alt="alt" class="mx-auto" />
</template>