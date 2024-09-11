<script setup>
defineProps({
    title: {
        type: String,
        default: 'Cool Heading'
    },
    kicker: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'h2'
    },
    align: {
        type: String,
        default: 'left'
    }
});
</script>

<template>
    <component :is="type" :class="[align, 'text-black dark:text-gray-400 font-bold text-3xl w-full']">{{ title }}</component>
    <p :class="[align, 'text-black dark:text-gray-400 w-full']">{{ kicker }}</p>
</template>

<style scoped>
    .left {
        text-align: left;
    }
    .right {
        text-align: right;
    }
    .center {
        text-align: center;
    }
</style>