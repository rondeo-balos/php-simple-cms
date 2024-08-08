<script setup>
defineProps({
    content: {
        type: String,
        required: true
    }
});
</script>

<template>
    <p>{{ content }}</p>
</template>