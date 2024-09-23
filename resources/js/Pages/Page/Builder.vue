<script setup>
import Nested from './Partials/Nested.vue';
import { ref, watch } from 'vue';
import Cog from '@/Icons/Cog.vue';
import Apps from '@/Icons/Apps.vue';
import Desktop from '@/Icons/Desktop.vue';
import Tablet from '@/Icons/Tablet.vue';
import Mobile from '@/Icons/Mobile.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ThemeToggler from '@/Components/CustomComponents/ThemeToggler.vue';
import AppHead from '@/Components/CustomComponents/AppHead.vue';
import Control from '@/Components/CustomComponents/Control.vue';

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
            const componentName = props.components[index][0];
            const componentModule = await import(`../../Public/Components/${componentName}.vue`);
            const componentProps = componentModule.default.props;
            const componentMeta = componentModule.default.meta;
            availableComponents.value.push({
                name: componentName,
                props: componentProps,
                meta: componentMeta
            });

            //console.log(`Fetched ${componentName}:`, componentProps);
        } catch (error) {
            console.error(`Error fetching:`, error);
        }
    } 
};

componentProps();

/** Draggable code */
let items = ref(props.content);

const addComponent = (name, props, meta) => {
    let properProps = {};
    Object.keys( props ).forEach( (key, index) => {
        let def = props[key].default;
        properProps[key] = def;
    });
    items.value.push({
        name, 
        nested: props.nested ?? false,
        edit: function() {
            currentLabel.value = 'Component Settings';
            currentName.value = name;
            currentProps.value = this.props;
            currentMeta.value = this.meta ?? {};
        },
        delete: function() {
            let confirmed = confirm( 'Are you sure you want to delete this component?' );
            if( confirmed ) {
                //const index = items.value.indexOf(this);
                //if( index > -1 ) items.value.splice( index, 1 );
                deleteComponent( this, items.value );
                currentLabel.value = 'Components';
            }
        },
        props: JSON.parse(JSON.stringify(properProps)), // Deep copy
        meta
    });

    save();
};

// Delete component
const deleteComponent = (item, list) => {
    const index = list.indexOf(item);
    if( index > -1 ) {
        list.splice( index, 1 );
    } else {
        // Recursively search nested lists if item is not found in the top-level list
        list.forEach( (nestedItem) => {
            //console.log( nestedItem );
            if( nestedItem.props.list && nestedItem.props.list.length ) {
                deleteComponent( item, nestedItem.props.list );
            }
        });
    }
};

// Edit component

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

// Responsive View
const breakpoints = ref('Desktop');
const currentLabel = ref('Components');
const currentName = ref( '' );
const currentProps = ref({});
const currentMeta = ref({});
</script>

<template>
    <AppHead title="Welcome" />
    <div class="flex flex-row">
        <div class="shadow bg-gray-50 dark:bg-gray-900 h-screen overflow-auto max-w-80 min-w-80 flex flex-col">
            <div class="text-center dark:text-white font-bold bg-gray-200 dark:bg-gray-800 p-3 uppercase">{{ currentLabel }}</div>
            <div class="flex-grow">

                <div v-if="currentLabel === 'Components'" class="flex flex-row flex-wrap p-1">
                    <div class="w-1/2 flex-0 p-1" v-for="(component, index) in availableComponents">
                        <SecondaryButton @click="addComponent(component.name, component.props, component.meta)" class="w-full flex flex-col gap-4"><div class="w-5 h-5" v-html="props.components[index][1]"></div> {{ component.name }}</SecondaryButton>
                    </div>
                </div>

                <div v-else-if="currentLabel === 'Page Settings'" class="flex flex-col p-1"></div>

                <div v-else class="flex flex-col p-1">
                    <div class="dark:text-white text-center py-2 border-t border-b border-gray-600 dark:border-white bg-black dark:bg-white bg-opacity-10 dark:bg-opacity-10 mb-3">{{ currentName }}</div>
                    <div v-for="(value, label) in currentProps" :key="label" class="mb-4 px-3">
                        <div v-if="!Array.isArray(value) && Object.keys(currentMeta).length > 0" class="flex flex-row items-center flex-wrap">

                            <Control :label="label.replace( /_/g, ' ' )" :control="currentMeta[label].control" :options="currentMeta[label].values ?? []" v-model="currentProps[label]" />

                        </div>
                    </div>
                </div>

            </div>
            <div class="bg-gray-200 dark:bg-gray-800 p-1 flex flex-row gap-2">
                <SecondaryButton title="Components" @click="currentLabel = 'Components'">
                    <Apps :class="[currentLabel == 'Components' ? 'border-b-2 border-b-black dark:border-b-white':'', 'fill-white min-w-5 pb-1']"/>
                </SecondaryButton>
                <SecondaryButton title="Settings" @click="currentLabel = 'Page Settings'">
                    <Cog :class="[currentLabel == 'Page Settings' ? 'border-b-2 border-b-black dark:border-b-white':'', 'fill-white min-w-5 pb-1']"/>
                </SecondaryButton>
                <SecondaryButton title="Save" @click="save" class="w-full justify-center">Save</SecondaryButton>
            </div>
        </div>

        <div class="flex-grow dark:bg-black flex flex-col">
            <div class="text-center dark:text-white font-bold bg-gray-300 dark:bg-gray-700 p-1 uppercase flex flex-row gap-1">
                <SecondaryButton title="Desktop" @click="breakpoints = 'Desktop'">
                    <Desktop :class="[breakpoints === 'Desktop' ? 'border-b-2 border-b-black dark:border-b-white':'', 'fill-white min-w-4 pb-1']" />
                </SecondaryButton>
                <SecondaryButton title="Tablet" @click="breakpoints = 'Tablet'">
                    <Tablet :class="[breakpoints === 'Tablet' ? 'border-b-2 border-b-black dark:border-b-white':'', 'fill-white min-w-4 pb-1']" />
                </SecondaryButton>
                <SecondaryButton title="Mobile" @click="breakpoints = 'Mobile'">
                    <Mobile :class="[breakpoints === 'Mobile' ? 'border-b-2 border-b-black dark:border-b-white':'', 'fill-white min-w-4 pb-1']" />
                </SecondaryButton>
                <ThemeToggler class="ms-auto" />
            </div>
            <iframe src="http://127.0.0.1:8000/preview" :class="[breakpoints === 'Desktop' ? 'w-full' : breakpoints === 'Tablet' ? 'w-[820px]' : 'w-[360px]', 'h-full mx-auto transition-all scroll']"></iframe>
        </div>

        <div class="shadow bg-gray-50 dark:bg-gray-900 h-screen min-w-64 flex flex-col">
            <div class="text-center dark:text-white font-bold bg-gray-200 dark:bg-gray-800 p-3 uppercase">Navigation</div>
            <div class="flex-grow h-100 p-1 px-2 overflow-y-auto">
                <div v-if="items.length <= 0" class="dark:text-white h-full flex items-center justify-center text-center border-2 border-dashed">
                    Add Components <br>
                    to get started
                </div>
                <Nested :list="items" />
            </div>
        </div>
    </div>

    <!--<PrimaryButton @click="save">Save</PrimaryButton>-->
</template>