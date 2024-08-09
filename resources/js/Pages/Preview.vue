<script setup>
import { ref, defineAsyncComponent, onMounted, onUnmounted } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    title: {
        type: String,
        default: 'Default'
    },
    layout: {
        type: String,
        default: 'Default'
    },
    raw: {
        type: Array,
        default: []
    }
});

const components = ref([]);

const loadLayout = (layout) => {
    return defineAsyncComponent(() => import(`../Layouts/Public/${layout}.vue`));
};

const addComponent = (name, props = {}) => {
    const dynamicComponent = defineAsyncComponent(() => import(`../Components/Public/${name}.vue`));
    components.value.push({ dynamicComponent, props });
    console.log('Component added:', components.value); // Debugging
};

const loadComponents = ( data ) => {
    Object.keys(data).forEach( key => {
        let item = data[key];
        addComponent( item.name, item.props );
    });
};

const layout = loadLayout( props.layout );
loadComponents( props.raw );

/** Receive message */
const handleMessage = (event) => {
    components.value = [];
    loadComponents( JSON.parse(event.data.payload) );
};

onMounted(() => {
  window.addEventListener('message', handleMessage);
});

onUnmounted(() => {
  window.removeEventListener('message', handleMessage);
});
</script>

<template>
    <Head :title="title" />

    <div class="dark">
        <div class="bg-gray-200 dark:bg-gray-950">
            <component :is="layout">
                <div v-for="(item, index) in components" :key="index">
                    <!-- Directly render the dynamically imported component -->
                    <component :is="item.dynamicComponent" v-bind="item.props" />
                </div>
            </component>
        </div>
    </div>
</template>