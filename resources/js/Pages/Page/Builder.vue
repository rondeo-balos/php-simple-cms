<script setup>
import Nested from './Partials/Nested.vue';
import { ref, watch } from 'vue';
import Cog from '@/Icons/Cog.vue';
import Desktop from '@/Icons/Desktop.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Apps from '@/Icons/Apps.vue';
import TextInput from '@/Components/TextInput.vue';
import ThemeToggler from '@/Components/CustomComponents/ThemeToggler.vue';
import Mobile from '@/Icons/Mobile.vue';
import SelectV2 from '@/Components/CustomComponents/SelectV2.vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import ImageSelector from '@/Components/CustomComponents/ImageSelector.vue';
import hljs from 'highlight.js';
import CodeEditor from 'simple-code-editor';
import AppHead from '@/Components/CustomComponents/AppHead.vue';

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
const isMobile = ref(false);
const currentLabel = ref('Components');
const currentName = ref( '' );
const currentProps = ref({});
const currentMeta = ref({});
</script>

<template>
    <AppHead title="Welcome" />
    <div class="flex flex-row">
        <div class="shadow bg-gray-50 dark:bg-gray-900 h-screen overflow-auto max-w-80 flex flex-col">
            <div class="text-center dark:text-white font-bold bg-gray-200 dark:bg-gray-800 p-2 uppercase">{{ currentLabel }}</div>
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
                            
                            <label class="dark:text-white font-bold block capitalize mb-1 flex-grow">{{ label.replace( /_/g, ' ' ) }}</label>
                            
                            <!--<TextInput v-model="currentProps[label]" class="w-full"></TextInput>-->
                            <!-- Check control type -->
                            <TextInput v-if="!currentMeta[label].control || currentMeta[label].control === 'text'" v-model="currentProps[label]" />
                            <!-- Select input for 'select' control type -->
                            <div v-else-if="currentMeta[label].control === 'select'">
                                <SelectV2 :options="currentMeta[label].values" :selected="currentProps[label]" v-model="currentProps[label]"/>
                            </div>
                            <!-- Number input for 'number' control type -->
                            <input v-else-if="currentMeta[label].control === 'number'" type="number" v-model="currentProps[label]" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" />
                            <!-- Textarea input for 'textarea' control type -->
                            <textarea v-else-if="currentMeta[label].control === 'textarea'" v-model="currentProps[label]" class="basis-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                            <div v-else-if="currentMeta[label].control === 'richtext'" class="basis-full bg-white">
                                <QuillEditor contentType="html" v-model:content="currentProps[label]" theme="snow"/>
                            </div>
                            <ImageSelector v-else-if="currentMeta[label].control === 'image'" v-model="currentProps[label]" />
                            <CodeEditor v-else-if="currentMeta[label].control === 'code'" v-model="currentProps[label]" class="basis-full" :line-nums="true" :languages="[['html']]" width="100%" ></CodeEditor>

                        </div>
                    </div>
                </div>

            </div>
            <div class="bg-gray-200 dark:bg-gray-800 p-1 flex flex-row gap-2">
                <ThemeToggler class="hidden" />
                <SecondaryButton title="Components" @click="currentLabel = 'Components'">
                    <Apps :class="[currentLabel == 'Components' ? 'border-b-2 border-b-black dark:border-b-white':'', 'fill-white min-w-5 pb-1']"/>
                </SecondaryButton>
                <SecondaryButton title="Settings" @click="currentLabel = 'Page Settings'">
                    <Cog :class="[currentLabel == 'Page Settings' ? 'border-b-2 border-b-black dark:border-b-white':'', 'fill-white min-w-5 pb-1']"/>
                </SecondaryButton>
                <SecondaryButton title="Responsive Mode" @click="isMobile = !isMobile">
                    <Mobile v-if="!isMobile" class="fill-white min-w-5 pb-1" />
                    <Desktop v-else class="fill-white min-w-5 pb-1" />
                </SecondaryButton>
                <SecondaryButton title="Save" @click="save" class="w-full justify-center">Save</SecondaryButton>
            </div>
        </div>

        <div class="flex-grow dark:bg-black">
            <iframe src="http://127.0.0.1:8000/preview" :class="[isMobile ? 'w-[360px]' : 'w-full', 'h-full mx-auto transition-all']"></iframe>
        </div>

        <div class="shadow p-1 bg-gray-50 dark:bg-gray-900 h-screen overflow-y-auto min-w-64 px-2">
            <div v-if="items.length <= 0" class="dark:text-white h-full flex items-center justify-center text-center border-2 border-dashed">
                Add Components <br>
                to get started
            </div>
            <Nested :list="items" />
        </div>
    </div>

    <!--<PrimaryButton @click="save">Save</PrimaryButton>-->
</template>