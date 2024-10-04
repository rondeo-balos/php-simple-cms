<script setup>
import Nested from './Partials/Nested.vue';
import { onMounted, onUnmounted, ref, watch } from 'vue';
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
    content: {
        type: Array,
        default: []
    }
});

//console.log( componentDefinitions );

/** Fetch available public components */
let availableComponents = ref([]);
for( const index in componentDefinitions ) {
    const component = componentDefinitions[index];
    const name = component.options.name;
    const meta = component.options.meta;
    const icon = component.options.icon;
    const props = component.props;
    availableComponents.value.push({
        name,
        props,
        meta,
        icon
    });
}

/** Draggable code */
let items = ref(props.content);

const addComponent = (name, props, meta) => {
    items.value.push({
        id: (Math.random() + 1).toString(36).substring(5),
        name, 
        nested: props.nested ?? false,
        props: JSON.parse(JSON.stringify(props)), // Deep copy
        meta
    });

    recalculateFunctions(items.value);
    save();
};

const recalculateFunctions = (items) => {
    //console.log( items );
    items.map( (item) => {
        //console.log( item.meta );
        item.edit = function() {
            editComponent( item, items );
        };
        item.delete = function() {
            let confirmed = confirm( 'Are you sure you want to delete this component?' );
            if( confirmed ) {
                deleteComponent( item, items );
                currentLabel.value = 'Components';
            }
        };

        if( item.nested ) {
            recalculateFunctions(item.props.list);
        }
    });
}

// edit component
const editComponent = (item, list) => {
    currentLabel.value = 'Component Settings';
    currentName.value = item.name;
    currentProps.value = item.props;
    currentMeta.value = item.meta ?? {};
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
/*const form = useForm({
    datainput: null
});*/
const form = ref(null);
const datainput = ref(null);
const iframe =  ref(null);
onMounted(() => form.value.submit() );
onMounted(() => window.addEventListener( 'message', handleMessage ));
onUnmounted(() => window.removeEventListener('message', handleMessage));
const handleMessage = (message) => {
    //console.log( message );
    if( message.origin !== window.location.origin ) return;
    // If message was updated data
    if( message.data.payload ) {
        const updatedData = message.data.payload;
        if( updatedData ) {
            items.value = updatedData;
            recalculateFunctions( items.value );
        }
    } else if(message.data.edit) { // If message was edit
        let item = findItemById( items.value, message.data.edit );
        if( item ) {
            editComponent( item, items.value );
        }
    } else if( message.data.delete ) { // If message was delete
        let item = findItemById( items.value, message.data.delete );
        if( item ) {
            let confirmed = confirm( 'Are you sure you want to delete this component?' );
            if( confirmed ) {
                deleteComponent( item, items.value );
                currentLabel.value = 'Components';
            }   
        }
    }
};

const preview = () => {
    datainput.value.value  = JSON.stringify(items.value);
    //form.value.submit();
    const message = {
        type: 'DATA',
        payload: datainput.value.value
    };
    if( iframe.value && iframe.value.contentWindow ) {
        iframe.value.contentWindow.postMessage( message );
    }
};

const findItemById = (items, id) => {
    for (let item of items) {
        // Check if current item's ID matches
        if (item.id === id) {
            return item;
        }
        
        // If the item has nested items, search in the nested array
        if (item.props.nested && Array.isArray(item.props.list)) {
            const foundInNested = findItemById(item.props.list, id);
            if (foundInNested) {
                return foundInNested;
            }
        }
    }
    
    // If no item is found, return null
    return null;
};

// Watch the items ref for changes
watch(items, (newVal) => {
    preview();
}, { deep: true });

const save = () => {
    //console.log( JSON.stringify(items.value, null, 2) );
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
            <div class="text-center dark:text-white font-bold bg-gray-200 dark:bg-gray-800 p-3 uppercase sticky top-0 shadow-xl z-30">{{ currentLabel }}</div>
            <div class="flex-grow">

                <div v-if="currentLabel === 'Components'" class="flex flex-row flex-wrap p-1">
                    <div class="w-1/2 flex-0 p-1" v-for="(component, index) in availableComponents">
                        <SecondaryButton @click="addComponent(component.name, component.props, component.meta)" class="w-full flex flex-col gap-4"><div class="w-5 h-5" v-html="component.icon"></div> {{ component.name }}</SecondaryButton>
                    </div>
                </div>

                <div v-else-if="currentLabel === 'Page Settings'" class="flex flex-col p-1"></div>

                <div v-else class="flex flex-col p-1">
                    <div class="dark:text-white text-center py-2 border-t border-b border-gray-600 dark:border-white bg-black dark:bg-white bg-opacity-10 dark:bg-opacity-10 mb-3">{{ currentName }}</div>
                    <!--<div v-for="(meta, label) in currentMeta" :key="label" class="mb-4 px-3">
                        <Control :label="label.replace( /_/g, ' ' )" :control="meta.control" :options="meta.values ?? []" v-model="currentProps[label]" />
                    </div>-->
                    <!--<div v-for="(value, label) in currentProps" :key="label" class="mb-4 px-3">
                        <div v-if="!Array.isArray(value) && Object.keys(currentMeta).length > 0" class="flex flex-row items-center flex-wrap">

                            <Control :label="label.replace( /_/g, ' ' )" :control="currentMeta[label].control" :options="currentMeta[label].values ?? []" v-model="currentProps[label]" />

                        </div>
                    </div>-->
                    <div class="flex flex-col divide-y divide-slate-300 dark:divide-slate-700 border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-gray-800 shadow">
                        <div v-for="(meta, label) in currentMeta" :key="label">
                            <!-- Render grouped fields -->
                            <div v-if="meta.fields" class="p-2">
                                <label class="dark:text-white font-bold block capitalize mb-1 flex-grow">{{ label.replace( /_/g, ' ' ) }}</label>
                                <div class="flex flex-row">
                                    <div v-for="(fieldOption, fieldKey) in meta.fields" :key="fieldKey" class="p-1 w-full">
                                        <Control label="" :options="fieldOption.values ?? []" :control="fieldOption.control" v-model="currentProps[fieldKey]" class="w-full" />
                                    </div>
                                </div>
                            </div>
                            <!-- Render ungrouped fields as well -->
                            <div v-else class="p-2 flex flex-col">
                                <Control :label="label.replace( /_/g, ' ' )" :options="meta.values ?? []" :control="meta.control" v-model="currentProps[label]" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="bg-gray-200 dark:bg-gray-800 p-1 flex flex-row gap-2 sticky bottom-0" style="box-shadow: 0px -6px 8px #0003;">
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
            <form action="http://127.0.0.1:8000/twig-preview" target="preview" method="GET" ref="form">
                <input type="hidden" name="datainput" ref="datainput">
            </form>
            <iframe name="preview" ref="iframe" src="" :class="[breakpoints === 'Desktop' ? 'w-full' : breakpoints === 'Tablet' ? 'w-[820px]' : 'w-[360px]', 'h-full mx-auto transition-all scroll']"></iframe>
            
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