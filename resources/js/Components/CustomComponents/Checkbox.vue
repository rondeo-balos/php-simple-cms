<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel();
defineProps([ 'options' ]);

onMounted(() => {
    if( !model.value ) {
        model.value = [];
    }
});
</script>
<template>
    <div class="flex flex-col gap-3">
        <div v-for="(option, index) in options" class="flex flex-row gap-2 items-center">
            <input type="checkbox" :value="option" :id="index" v-model="model" />
            <label :for="index" class="dark:text-white">{{ option }}</label>
        </div>
    </div>
</template>