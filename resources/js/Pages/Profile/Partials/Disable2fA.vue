<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const google2fa_enabled = ref( usePage().props.auth.user.google2fa_secret );
</script>

<template>
    <section>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ google2fa_enabled ? 'Disable' : 'Enable' }} Two Factor Authentication</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            <template v-if="google2fa_enabled">Disable Two Factor Authentication.</template>
            <template v-else>Add an extra layer of security by using an authenticator app to generate one-time codes.</template>
        </p>
        <Link v-if="google2fa_enabled" :href="route( '2fa.disable' )" method="patch">Disable</Link>
        <Link v-else :href="route( '2fa.enable' )">Enable</Link>
    </section>
</template>