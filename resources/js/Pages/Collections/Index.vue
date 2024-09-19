<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AppHead from '@/Components/CustomComponents/AppHead.vue';
import Control from '@/Components/CustomComponents/Control.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps([ 'status', 'title', 'collection', 'data', 'id' ]);

const options = ref({});
let formData = useForm({});

onMounted( async () => {
    try {
        const collectionModules = import.meta.glob( '../../Public/Collections/*.js' );
        const collectionPath = `../../Public/Collections/${props.collection}.js`;

        if (collectionModules[collectionPath]) {
            const module = await collectionModules[collectionPath]();
            options.value = module.default.meta || {};
            let fields = {};
            Object.keys(options.value).forEach( key => {
                const metaField = options.value[key];
                if( metaField.fields ) { // Grouped fields
                    Object.keys( metaField.fields ).forEach( fieldKey => {
                        fields[fieldKey] = props.data ? props.data[fieldKey] : (metaField.fields[fieldKey].default ?? '');
                    });
                } else { // Handle ungrouped fields
                    fields[key] = props.data ? props.data[key] : (metaField.default ?? '');
                }
                /*if( !(key in fields) ) {
                    fields[key] = props.data ? props.data[key] : (options.value[key].default ?? '');
                }*/
            });
            console.log( fields );
            formData = useForm(fields);
        }
        
    } catch( error ) {
        console.error( 'Error loading collection options: ', error );
    }
});

const save = () => {
    if( props.id ) {
        formData.patch( route( 'collection.update', [props.collection, props.id]), {
            preserveScroll: true,
            onError: (e) => console.log(e)
        });
        return;
    }
    formData.post( route('collection.create', [props.collection]), {
        preserveScroll: true,
        onError: (e) => console.log(e)
    });
};
</script>
<template>
    <AppHead :title="title[0].toUpperCase() + title.slice(1)" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row items-center">
                <!-- Title -->
                <div class="flex-grow">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        <span>{{ title }}</span>
                    </h2>
                </div>
            </div>
        </template>

        <div class="py-2">
            <div class="sm:px-6 lg:px-8 space-y-6">
                <form @submit.prevent="save">
                    <div class="flex flex-col divide-y divide-slate-300 dark:divide-slate-700 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-gray-800 shadow">
                        <div v-for="(option, key) in options" :key="key">
                            <!-- Render grouped fields -->
                            <div v-if="option.fields" class="flex flex-col md:flex-row max-md:divide-y md:divide-x divide-slate-300 dark:divide-slate-700">
                                <div v-for="(fieldOption, fieldKey) in option.fields" :key="fieldKey" class="p-4 w-full">
                                    <div class="flex flex-col">
                                        <Control :label="fieldKey.replace( /_/g, ' ' )" :options="fieldOption.values ?? []" :control="fieldOption.control" v-model="formData[fieldKey]" />
                                    </div>
                                </div>
                            </div>
                            <!-- Render ungrouped fields as well -->
                            <div v-else class="p-4 flex flex-col">
                                <Control :label="key.replace( /_/g, ' ' )" :options="option.values ?? []" :control="option.control" v-model="formData[key]" />
                            </div>
                        </div>
                        <!--<div v-for="(option, key) in options" :key="key" class="mb-4 px-3">
                            <Control :label="key.replace( /_/g, ' ' )" :options="option.values ?? []" :control="option.control" v-model="formData[key]" />
                        </div>-->
                    </div>
                    
                    <PrimaryButton class="mt-3" :class="{ 'opacity-25': formData.processing }" :disabled="formData.processing" >Save</PrimaryButton>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>