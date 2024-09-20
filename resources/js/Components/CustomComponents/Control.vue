<script setup>
import TextInput from '@/Components/TextInput.vue';
import SelectV2 from '@/Components/CustomComponents/SelectV2.vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import ImageSelector from '@/Components/CustomComponents/ImageSelector.vue';
import CodeEditor from 'simple-code-editor';

const model = defineModel();
defineProps([ 'control', 'options', 'label' ]);
</script>

<template>
    <label class="dark:text-white font-bold block capitalize mb-1 flex-grow">{{ label }}</label>

    <!-- Check control type -->
    <TextInput v-if="!control || control === 'text'" v-model="model" />
    <!-- Select input for 'select' control type -->
    <div v-else-if="control === 'select'">
        <SelectV2 :options="options" :selected="model" v-model="model"/>
    </div>
    <!-- Number input for 'number' control type -->
    <input v-else-if="control === 'number'" type="number" step=".1" v-model="model" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
    <!-- Textarea input for 'textarea' control type -->
    <textarea v-else-if="control === 'textarea'" v-model="model" class="basis-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm min-h-24"></textarea>
    <div v-else-if="control === 'richtext'" class="basis-full bg-white">
        <QuillEditor contentType="html" v-model:content="model" theme="snow" style="height: 250px"/>
    </div>
    <ImageSelector v-else-if="control === 'image'" v-model="model" />
    <CodeEditor v-else-if="control === 'code'" v-model="model" class="basis-full" :line-nums="true" :languages="[['html']]" width="100%" ></CodeEditor>
</template>