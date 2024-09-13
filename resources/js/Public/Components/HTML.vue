<script setup>
defineProps({
    code: {
        type: String,
        default: ''
    }
});

defineOptions({
    meta: {
        code: {
            control: 'code'
        }
    }
});
</script>

<template>
    <div v-html="code"></div>
</template>