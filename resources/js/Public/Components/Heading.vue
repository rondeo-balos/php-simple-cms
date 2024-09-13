<script setup>
defineProps({
    title: {
        type: String,
        default: 'Cool Heading'
    },
    kicker: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'h2'
    },
    align: {
        type: String,
        default: 'text-left'
    }
});

defineOptions({
    meta: {
        title: {
            control: 'text'
        },
        kicker: {
            control: 'textarea'
        },
        type: {
            control: 'select',
            values: {
                'H1': 'h1',
                'H2': 'h2',
                'H3': 'h3',
                'H4': 'h4',
                'H5': 'h5',
                'H6': 'h6'
            }
        },
        align: {
            control: 'select',
            values: {
                'Left': 'text-left',
                'Center': 'text-center',
                'Right': 'text-right'
            }
        }
    }
});
</script>

<template>
    <component :is="type" :class="[align, 'text-black dark:text-gray-400 font-bold text-3xl w-full']">{{ title }}</component>
    <p :class="[align, 'text-black dark:text-gray-400 w-full']">{{ kicker }}</p>
</template>