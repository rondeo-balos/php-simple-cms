<script setup>
import { ref } from 'vue';

const definedProps = defineProps({
    'onChange': {
        type: Function
    },
    'options': {
        type: Array
    },
    'selected': {
        type: String
    },
    'radio': {
        type: Boolean
    }
});

const selected = ref(definedProps.selected || definedProps.options[0]);
const isOpen = ref(false);

const focusOut = () => {
    window.setTimeout(()=> {isOpen.value = !isOpen.value}, 300);
}

const triggerChange = (value) => {
    selected.value = value;
    definedProps.onChange( value );
}
</script>
<template>
    <div class="relative mt-1">
        <button @focusin="isOpen = !isOpen" @focusout="focusOut" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
            {{ selected }}
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div v-if="isOpen" class="z-10 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 absolute right-0 top-12">
            <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
                <li v-for="option in options">
                    <div @click="triggerChange(option)" class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        <input v-if="radio" :checked="option === selected" :id="'filter-radio-' + option" type="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 checked:ring-blue-500 focus:ring-blue-500 checked:dark:ring-blue-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 checked:dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label :for="'filter-radio-' + option" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{ option }}</label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>