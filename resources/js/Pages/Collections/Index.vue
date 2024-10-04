<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AppHead from '@/Components/CustomComponents/AppHead.vue';
import Control from '@/Components/CustomComponents/Control.vue';
import TitleBar from '@/Components/CustomComponents/TitleBar.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps([ 'status', 'title', 'collection', 'data', 'id' ]);

const options = ref({});
let formData = useForm({});

onMounted( () => {
    const collection = window.collections[props.collection];

    if( collection ) {
        options.value = collection.meta || {};
        let fields = {};
        for( const [key, metaField] of Object.entries(collection.meta) ) {
            if( metaField.fields ) { // Grouped fields
                for( const [key, metaSubField] of Object.entries(metaField.fields) ) {
                    console.log( props.data );
                    fields[key] = props.data ? props.data[key] : (metaSubField.default ?? '');
                }
            } else { // Handle ungrouped fields
                fields[key] = props.data ? props.data[key] : (metaField.default ?? '');
            }
        }
        formData = useForm(fields);
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
            <TitleBar :title="title" :back="true" />
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
                                        <InputError class="mt-2" :message="formData.errors[fieldKey]" />
                                    </div>
                                </div>
                            </div>
                            <!-- Render ungrouped fields as well -->
                            <div v-else class="p-4 flex flex-col">
                                <Control :label="key.replace( /_/g, ' ' )" :options="option.values ?? []" :control="option.control" v-model="formData[key]" />
                                <InputError class="mt-2" :message="formData.errors[key]" />
                            </div>
                        </div>
                        <!--<div v-for="(option, key) in options" :key="key" class="mb-4 px-3">
                            <Control :label="key.replace( /_/g, ' ' )" :options="option.values ?? []" :control="option.control" v-model="formData[key]" />
                        </div>-->
                    </div>
                    
                    <div class="flex flex-row justify-between items-center">
                        <PrimaryButton class="mt-3" :class="{ 'opacity-25': formData.processing }" :disabled="formData.processing" >Save</PrimaryButton>
                        <div v-if="formData.isDirty" class="text-right dark:text-white mb-2">There are unsaved changes.</div>
                    </div>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>