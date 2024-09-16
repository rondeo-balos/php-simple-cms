<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link class="bg-[#0b58ca] hover:bg-[#3289f0] transition-all hover:scale-105 duration-500 px-4 py-2 font-bold text-white rounded-lg shadow table mx-auto">
        <slot />
    </Link>
</template>