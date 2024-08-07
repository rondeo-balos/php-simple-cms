<script setup>
import { ref } from 'vue';
import Ellipsis from '@/Icons/Ellipsis.vue';

const definedProps = defineProps({
    'onChange': {
        type: Function
    },
    'options': {
        type: Object
    }
});

const isOpen = ref(false);

const focusOut = () => {
    window.setTimeout(()=> {isOpen.value = !isOpen.value}, 300);
}

const triggerChange = (value, index) => {
    definedProps.onChange( value, index );
}
</script>
<template>
    <div class="relative mt-1 inline-block">
        <button @focusin="isOpen = !isOpen" @focusout="focusOut" class="inline-flex items-center text-gray-500 bg-transparent focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 dark:text-white dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
            <Ellipsis class="w-6" />
        </button>
        <!-- Dropdown menu -->
        <div v-if="isOpen" class="z-10 min-w-32 bg-white divide-y divide-gray-100 rounded-lg overflow-hidden shadow-md dark:bg-gray-700 dark:divide-gray-600 absolute right-0 top-12">
            <ul class="text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
                <li v-for="(option, index) in options">
                    <div @click="triggerChange(option, index)" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">
                        <label class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300 cursor-pointer">{{ index }}</label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>