<script setup>
import { ref, defineAsyncComponent } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppHead from '@/Components/CustomComponents/AppHead.vue';

const props = defineProps({
    title: {
        type: String,
        default: 'Default'
    },
    layout: {
        type: String,
        default: 'Default'
    }
});

const components = ref([]);
const raw = [];

const loadLayout = (layout) => {
    return defineAsyncComponent(() => import(`../Layouts/Public/${layout}.vue`));
};

const addComponent = (name, props = {}) => {
    const dynamicComponent = defineAsyncComponent(() => import(`../Components/Public/${name}.vue`));
    components.value.push({ dynamicComponent, props });
    raw.push({ name, props });
    console.log('Component added:', components.value); // Debugging
};

const savePage = () => {
    const pageData = JSON.stringify(raw);
    console.log(pageData);
};

const loadComponents = () => {
    let data = [{"name":"Text","props":{"content":"This is a paragraph text"}},{"name":"Text","props":{"content":"This is a paragraph text"}}];
    Object.keys(data).forEach( key => {
        let item = data[key];
        addComponent( item.name, item.props );
    });
};

const layout = loadLayout( props.layout );
loadComponents();
</script>

<template>
    <AppHead :title="title" />

    <div class="dark">
        <div class="bg-gray-200 dark:bg-gray-950">
            <component :is="layout">

                <div class="d-flex flex-row">
                    
                    <PrimaryButton @click="addComponent('Text', {})">Add Text</PrimaryButton>
                    <PrimaryButton @click="addComponent('Image', {})">Add Image</PrimaryButton>
                    <PrimaryButton @click="savePage">Save Page</PrimaryButton>
                </div>

                <div v-for="(item, index) in components" :key="index">
                    <!-- Directly render the dynamically imported component -->
                    <component :is="item.dynamicComponent" v-bind="item.props" />
                </div>
            </component>
        </div>
    </div>
</template>