<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Nested from './Partials/Nested.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    components: {
        type: Array,
        required: true
    },
    content: {
        type: Array,
        default: []
    }
});

/** Fetch available public components */
let availableComponents = ref([]);
const componentProps = async () => {
    for( const index in props.components ) {
        try {
            const componentName = props.components[index];
            const componentModule = await import(`../../Components/Public/${componentName}.vue`);
            const componentProps = componentModule.default.props;
            availableComponents.value.push({
                name: componentName,
                props: componentProps
            });

            console.log(`Fetched ${componentName}:`, componentProps);
        } catch (error) {
            console.error(`Error fetching:`, error);
        }
    } 
}

componentProps();

/** Draggable code */
let items = ref(props.content);

const addComponent = (name, props) => {
    let properProps = {};
    Object.keys( props ).forEach( (key, index) => {
        let def = props[key].default;
        properProps[key] = def;
    });
    items.value.push({
        name, 
        nested: props.nested ?? false,
        props: JSON.parse(JSON.stringify(properProps)) // Deep copy
    });

    save();
};

const preview = () => {
    console.log(JSON.stringify(items.value) );
    const iframe = document.querySelector( 'iframe' );
    const message = {
        type: 'DATA',
        payload: JSON.stringify(items.value)
    };

    if( iframe && iframe.contentWindow ) {
        iframe.contentWindow.postMessage( message );
    }
};

// Watch the items ref for changes
watch(items, (newVal) => {
    preview();
}, { deep: true });

const save = () => {
    console.log( JSON.stringify(items.value, null, 2) );
};
</script>

<template>
    <div class="flex flex-row">
        <div class="shadow p-1 bg-gray-900 h-screen overflow-auto max-w-52">
            <div class="flex flex-row flex-wrap">
                <div class="w-1/2 flex-0 p-1" v-for="component in availableComponents">
                    <PrimaryButton @click="addComponent(component.name, component.props)" class="w-full">Add {{ component.name }}</PrimaryButton>
                </div>
            </div>
        </div>

        <div class=" flex-grow">
            <iframe src="http://127.0.0.1:8000/preview" class="w-full h-full"></iframe>
        </div>

        <div class="shadow p-1 bg-gray-900 h-screen overflow-y-auto">
            <Nested :list="items" />
        </div>
    </div>

    <!--<PrimaryButton @click="save">Save</PrimaryButton>-->
</template>