<script setup>
defineProps({
    content: {
        type: String,
        default: 'This is a paragraph text'
    }
});

defineOptions({
    meta: {
        content: {
            control: 'richtext'
        }
    }
});
</script>

<template>
    <div class=" text-black dark:text-gray-400" v-html="content"></div>
</template>