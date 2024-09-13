<script setup>
import { ref, defineAsyncComponent, onMounted, onUnmounted, markRaw } from 'vue';
import AppHead from '@/Components/CustomComponents/AppHead.vue';

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

const loadLayout = (layout) => {
    return defineAsyncComponent(() => import(`../Public/Layouts/${layout}.vue`));
};

const components = ref([]);

const addComponent = (name, props = {}) => {
    const dynamicComponent = markRaw( defineAsyncComponent(() => import(`../Public/Components/${name}.vue`)) );
    components.value.push({ dynamicComponent, props });
    //console.log('Component added:', components.value); // Debugging
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
    <AppHead :title="title" />

    <div class="dark">
        <div class="bg-gray-200 dark:bg-gray-950">
            <component :is="layout">
                <!--<Container :list="components" />-->
                <div v-for="(item, index) in components" :key="index">
                    <component :is="item.dynamicComponent" v-bind="item.props" class="border border-transparent hover:border-blue-700 cursor-pointer" />
                </div>
            </component>
        </div>
    </div>
</template>