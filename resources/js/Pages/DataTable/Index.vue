<script setup>
import Search from '@/Icons/Search.vue';
import Select from '@/Components/CustomComponents/Select.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import SelectAction from '@/Components/CustomComponents/SelectAction.vue';
import AppHead from '@/Components/CustomComponents/AppHead.vue';

const definedProps = defineProps({
    title: {
        type: String
    },
    add: {
        type: String
    },
    per_page: {
        type: String
    },
    s: {
        type: String
    },
    columns: {
        type: Array
    },
    data: {
        type: Object
    },
    show: {
        type: Boolean,
        default: true
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

const confirmDeletion = (url) => {
    let confirmed = confirm( 'Are you sure you want to delete the selected data?' );
    if( confirmed ) router.delete( url );
}

onMounted(() => {
    current_url.value = window.location.href;
});

const isImage = (value) => {
  return typeof value === 'string' && /\.(jpg|jpeg|png|gif|svg|webp)$/.test(value);
};

const isLink = (value) => {
  return typeof value === 'string' && value.startsWith('http');
};
</script>

<template>
    <AppHead :title="title[0].toUpperCase() + title.slice(1) + 's'" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row items-center">
                <!-- Title -->
                <div class="flex-grow">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        <span v-if="definedProps.s">Search result for: '{{ definedProps.s }}'</span>
                        <span v-else>{{ title[0].toUpperCase() + title.slice(1) + 's' }}</span>
                    </h2>
                </div>

                <!-- Add button -->
                <Link :href="add" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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
                                    <Search class="w-4"/>
                                </div>
                                <input type="text" name="s" @change="search" v-model="s" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
                            </div>
                        </div>
                        
                    </div>
                    <div class="flex-none">
                        <!-- Per page -->
                        <div class="flex flex-row items-center gap-2">
                            <Select :options="['10', '20', '30', '40', '50']" :onChange="changePerPage" :selected="per_page" :radio="true"></Select>
                            <!--<select @change="changePerPage" v-model="per_page">
                                <option v-for="n in 5">{{ n * 10 }}</option>
                            </select>-->
                        </div>
                        
                    </div>
                </div>

                <!-- Table -->
                <div class="relative overflow-x-auto overflow-y-visible shadow-md sm:rounded-lg">
                    <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700">
                        <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" v-for="column in columns">{{ column }}</th>
                                <th scope="col" class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="data.data.length > 0" v-for="item in data.data" class="bg-white border-t dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50- dark:hover:bg-gray-600-">
                                <template v-if="show">
                                    <td class="px-6 py-4" v-for="column in columns">
                                        <template v-if="isImage(item[column])">
                                            <img :src="item[column]" alt="Image" class="w-16 h-16 object-cover" />
                                        </template>
                                        <template v-else-if="isLink(item[column])">
                                            <a :href="item[column]" class="text-blue-500 hover:underline" target="_blank">{{ item[column] }}</a>
                                        </template>
                                        <template v-else>
                                            {{ item[column] }}
                                        </template>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <!-- Temporary -->
                                        <SelectAction :options="item.actions" :onChange="(val, i) => {
                                            if( i === 'delete' ) {
                                                confirmDeletion( val );
                                            } else {
                                                router.get( val );
                                            }
                                            //router.delete( val )
                                        }" class="text-left"/>
                                    </td>
                                </template>
                                <template v-else>
                                    <td v-for="n in columns.length + 1" class="p-2 animate-pulse">
                                        <div class="h-5 w-full rounded-lg bg-gray-500 bg-opacity-10"></div>
                                    </td>
                                </template>
                            </tr>
                            <tr v-else class="bg-white border-t dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50- dark:hover:bg-gray-600-">
                                <td class="px-6 py-4 text-center" :colspan="columns.length + 1"> No data </td>
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