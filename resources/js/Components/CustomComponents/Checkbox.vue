<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel();
defineProps([ 'options' ]);

onMounted(() => {
    if( !Array.isArray(model.value) ) {
        model.value = [];
    }

    console.log( model.value );
});
</script>
<template>
    <div class="flex flex-col gap-3">
        <div v-for="(option, index) in options" class="flex flex-row gap-2 items-center">
            <input type="checkbox" :value="option" :id="index" v-model="model" class="cursor-pointer rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" />
            <label :for="index" class="dark:text-white cursor-pointer">{{ option }}</label>
        </div>
    </div>
</template>