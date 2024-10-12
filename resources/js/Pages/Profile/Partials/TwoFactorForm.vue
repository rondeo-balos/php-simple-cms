<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const google2fa_enabled = ref( usePage().props.auth.user.google2fa_secret );
</script>

<template>
    <section>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ google2fa_enabled ? 'Disable' : 'Enable' }} Two Factor Authentication</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 mb-5">
            <template v-if="google2fa_enabled">Disable Two Factor Authentication.</template>
            <template v-else>Add an extra layer of security by using an authenticator app to generate one-time codes.</template>
        </p>
        <Link v-if="google2fa_enabled" :href="route( '2fa.disable' )" method="patch" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Disable</Link>
        <Link v-else :href="route( '2fa.enable' )" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Enable</Link>
    </section>
</template>