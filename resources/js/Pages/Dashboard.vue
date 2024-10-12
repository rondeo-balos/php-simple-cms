<script setup>
import AppHead from '@/Components/CustomComponents/AppHead.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps([ 'auth' ]);
</script>

<template>
    <AppHead title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-2">
            <div class="sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">Welcome {{ auth.user.name }}!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
