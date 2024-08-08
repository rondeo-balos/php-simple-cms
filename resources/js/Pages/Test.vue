<script setup>
import { ref, defineAsyncComponent } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const components = ref([]);
const raw = [];

const addComponent = (name, props = {}) => {
    const dynamicComponent = defineAsyncComponent(() => import(`../Components/Frontend/${name}.vue`));
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

loadComponents();
</script>

<template>
    <PrimaryButton @click="addComponent('Text', { content: 'This is a paragraph text' })">Add Text</PrimaryButton>

    <div v-for="(item, index) in components" :key="index">
        <!-- Directly render the dynamically imported component -->
        <component :is="item.dynamicComponent" v-bind="item.props" />
    </div>

    <button @click="savePage">Save Page</button>
</template>