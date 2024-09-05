<script setup>
import { defineAsyncComponent, markRaw, ref } from 'vue';

const props = defineProps({
    list: {
        type: Array,
        default: []
    },
    nested: {
        type: Boolean,
        default: true
    }
});

const components = ref([]);

const addComponent = (name, props = {}) => {
    const dynamicComponent = markRaw( defineAsyncComponent(() => import(`./${name}.vue`)) );
    components.value.push({ dynamicComponent, props });
};

const loadComponents = ( data ) => {
    Object.keys(data).forEach( key => {
        let item = data[key];
        addComponent( item.name, item.props );
    });
};

loadComponents( props.list );
</script>

<template>
    <div class="flex flex-row">
        <div v-for="(item, index) in components" :key="item.id">
            <!-- Directly render the dynamically imported component -->
            <component :is="item.dynamicComponent" v-bind="item.props" />
        </div>
    </div>
</template>