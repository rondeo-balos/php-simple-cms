<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome"></Head>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        as
    </div>
</template>
