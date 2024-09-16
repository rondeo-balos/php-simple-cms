<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link class="bg-[#3289f0] hover:bg-[#22c4f5] transition-all hover:scale-105 duration-300 px-4 py-2 font-bold text-white rounded-lg shadow table mx-auto">
        <slot />
    </Link>
</template>