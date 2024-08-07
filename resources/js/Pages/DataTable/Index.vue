<script setup>
import Select from '@/Components/Select.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const definedProps = defineProps({
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
    },
    'per_page': {
        type: String
    },
    's': {
        type: String
    }
});

const per_page = ref(definedProps.per_page);
const s = ref(definedProps.s);
const current_url = ref(window.location.href);

const changePerPage = (val) => {
    const url = new URL( current_url.value );
    url.searchParams.append( 'per_page', /*per_page.value*/val );
    router.get( url.href );
};

const search = () => {
    const url = new URL( current_url.value );
    url.searchParams.append( 's', s.value );
    router.get( url.href );
};

const changePage = (link) => {
    if( link !== null ) {
        const page_url = new URL( link );

        const url = new URL( current_url.value );
        url.searchParams.append( 'page', page_url.searchParams.get( 'page' ) );
        router.get( url.href );
    }
};

onMounted(() => {
    current_url.value = window.location.href;
});
</script>

<template>
    <Head :title="title + 's'" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row items-center">
                <!-- Title -->
                <div class="flex-grow">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        <span v-if="definedProps.s">Search result for: '{{ definedProps.s }}'</span>
                        <span v-else>{{ title + 's' }}</span>
                    </h2>
                </div>

                <!-- Add button -->
                <Link :href="route(add)" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Add {{ title }}
                </Link>
                
            </div>
        </template>

        <div class="py-2">
            <div class="sm:px-6 lg:px-8 space-y-6">

                <div class="flex flex-row items-center">
                    <div class="flex-1 text-sm items-center dark:text-gray-400">
                        <!-- Search bar -->
                        <div>
                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" name="s" @change="search" v-model="s" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
                            </div>
                        </div>
                        
                    </div>
                    <div class="flex-none">
                        <!-- Per page -->
                        <div class="flex flex-row items-center gap-2">
                            <Select :options="['10', '20', '30', '40', '50']" :onChange="changePerPage" :selected="per_page"></Select>
                            <!--<select @change="changePerPage" v-model="per_page">
                                <option v-for="n in 5">{{ n * 10 }}</option>
                            </select>-->
                        </div>
                        
                    </div>
                </div>

                <!-- Table -->
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

                <!-- Pagination -->
                <div class="flex flex-row items-center">
                    <div class="flex-1 text-sm font-semibold dark:text-gray-500">
                        Showing {{ data.from  }} to {{ data.to }} of {{ data.total }} {{ title }}s
                    </div>
                    <nav class="flex-none">
                        <ul class="flex justify-center">
                            <li v-for="(link, index) in data.links">
                                <Link v-if="link.url" href="#" @click.prevent="changePage(link.url)" :class="[
                                    'flex items-center justify-center px-3 h-8 leading-tight border', 
                                    'border-gray-300 dark:border-gray-700',
                                    'dark:hover:bg-gray-700 dark:hover:text-white', {
                                        'rounded-l-md': index === 0,
                                        'rounded-r-md': index === data.links.length - 1
                                    }, index === data.current_page ? 'text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-700 dark:text-white': 'text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400' ]" v-html="link.label"></Link>
                                <span v-else v-html="link.label" :class="[
                                    'flex items-center justify-center px-3 h-8 leading-tight border',
                                    'border-gray-300 dark:border-gray-700 text-gray-500 bg-white',
                                    'hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400', {
                                        'rounded-l-md': index === 0,
                                        'rounded-r-md': index === data.links.length - 1
                                    } ]"></span>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>

        
        
    </AuthenticatedLayout>
</template>