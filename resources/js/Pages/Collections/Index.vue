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
    console.log( props.data );
    try {
        const collectionModules = import.meta.glob( '../../Public/Collections/*.js' );
        const collectionPath = `../../Public/Collections/${props.collection}.js`;

        if (collectionModules[collectionPath]) {
            const module = await collectionModules[collectionPath]();
            options.value = module.default.meta || {};
            let fields = {};
            Object.keys(options.value).forEach( key => {
                if( !(key in fields) ) {
                    fields[key] = props.data ? props.data[key] : (options.value[key].default ?? '');
                }
            });
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
    <AppHead :title="title + 's'" />

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
                    <div v-for="(option, key) in options" :key="key" class="mb-4 px-3">
                        <Control :label="key.replace( /_/g, ' ' )" :options="option.values ?? []" :control="option.control" v-model="formData[key]" />
                    </div>

                    <PrimaryButton class="ms-3" :class="{ 'opacity-25': formData.processing }" :disabled="formData.processing" >Save</PrimaryButton>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>