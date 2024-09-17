<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AppHead from '@/Components/CustomComponents/AppHead.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectV2 from '@/Components/CustomComponents/SelectV2.vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import ImageSelector from '@/Components/CustomComponents/ImageSelector.vue';
import CodeEditor from 'simple-code-editor';

const props = defineProps([ 'status', 'title', 'collection' ]);

const options = ref({});
const formData = ref({});

onMounted( async () => {
    try {
        const collectionModules = import.meta.glob( '../../Public/Collections/*.js' );
        const collectionPath = `../../Public/Collections/${props.collection}.js`;

        if (collectionModules[collectionPath]) {
            const module = await collectionModules[collectionPath]();
            options.value = module.default.meta || {};
            console.log( 'options', options );
        }
        
    } catch( error ) {
        console.error( 'Error loading collection options: ', error );
    }
})
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
                <div v-for="(option, key) in options" :key="key" class="mb-4 px-3">
                    <label class="dark:text-white font-bold block capitalize mb-1 flex-grow">{{ key.replace( /_/g, ' ' ) }}</label>
                    <!-- Check control type -->
                    <TextInput v-if="!option.control || option.control === 'text'" v-model="formData[key]" />
                    <!-- Select input for 'select' control type -->
                    <div v-else-if="option.control === 'select'">
                        <SelectV2 :options="option.values" :selected="formData[key]" v-model="formData[key]"/>
                    </div>
                    <!-- Number input for 'number' control type -->
                    <input v-else-if="option.control === 'number'" type="number" v-model="formData[key]" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                    <!-- Textarea input for 'textarea' control type -->
                    <textarea v-else-if="option.control === 'textarea'" v-model="formData[key]" class="basis-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                    <div v-else-if="option.control === 'richtext'" class="basis-full bg-white">
                        <QuillEditor contentType="html" v-model:content="formData[key]" theme="snow"/>
                    </div>
                    <ImageSelector v-else-if="option.control === 'image'" v-model="formData[key]" />
                    <CodeEditor v-else-if="option.control === 'code'" v-model="formData[key]" class="basis-full" :line-nums="true" :languages="[['html']]" width="100%" ></CodeEditor>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>