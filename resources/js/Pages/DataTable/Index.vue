<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    'title': {
        type: String
    },
    'add': {
        type: String
    },
    'columns': {
        type: Array
    },
    'data': {
        type: Object
    }
});

</script>

<template>
    <Head :title="title + 's'" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row items-center">
                <div class="flex-grow">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ title + 's' }}</h2>
                </div>
                <Link :href="route(add)" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Add {{ title }}
                </Link>
            </div>
        </template>

        <div class="py-2">
            <div class="sm:px-6 lg:px-8 space-y-6">

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" v-for="column in columns">{{ column }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" v-for="item in data.data">
                                <td class="px-6 py-4" v-for="column in columns">{{ item[column] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        
        
    </AuthenticatedLayout>
</template>