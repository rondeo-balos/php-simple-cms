<script setup>
import Header from '@/Pages/Partials/Header.vue';
import Footer from '@/Pages/Partials/Footer.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Coming Soon - Rondeo Balos">
        <meta name="description" content="This page is coming soon... Sorry for the inconvenience">
        <meta name="robots" content="noindex">
        <link rel="icon" href="https://cdn.jsdelivr.net/gh/rondeo-balos/cdn/optimized/logo-transparent.webp">
    </Head>

    <div class="bg-[#151924] text-gray-200 main-content min-h-screen">
        <Header />

        <!-- Main content -->
        <div>
            <div class="max-w-screen-xl px-2 py-20 mx-auto">
                <h1 class="kanit uppercase text-4xl sm:text-6xl lg:text-7xl lg:-mb-3 xl:-me-5 font-black flex flex-col lg:flex-row justify-between items-center text-[#293448]">
                    Coming Soon...
                </h1>
            </div>
        </div>

        <Footer />
    </div>
</template>