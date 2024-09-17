<script setup>
import { computed, defineAsyncComponent, markRaw, ref } from 'vue';

const props = defineProps({
    list: {
        type: Array,
        default: []
    },
    nested: {
        type: Function,
        default: () => true
    },
    direction: {
        type: String,
        default: ''
    },
    justify: {
        type: String,
        default:  ''
    },
    align: {
        type: String,
        default: ''
    },
    gap_x: {
        type: Number,
        default: 20
    },
    gap_y: {
        type: Number,
        default: 20
    },
    classes: {
        type: String,
        default: ''
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

defineOptions({
    meta: {
        direction: {
            control: 'select',
            values: {
                'Row': 'flex-row',
                'Column': 'flex-col',
                'Row Reverse': 'flex-row-reverse',
                'Column Reverse': 'flex-col-reverse'
            }
        },
        justify: {
            control: 'select',
            values: {
                'Start': 'justify-start',
                'Center': 'justify-center',
                'End': 'justify-end',
                'Space Between': 'justify-between',
                'Space Around': 'justify-around',
                'Space Evenly': 'justify-evenly'
            }
        },
        align: {
            control: 'select',
            values: {
                'Start': 'items-start',
                'Center': 'items-center',
                'End': 'items-end',
                'Stretch': 'items-stretch'
            }
        },
        gap_x: {
            control: 'number'
        },
        gap_y: {
            control: 'number'
        },
        classes: {
            control: 'text'
        }
    }
});

const computedStyle = computed(() => ({
    'row-gap': `${props.gap_x}px`,
    'column-gap': `${props.gap_y}px`
}));
</script>

<template>
    <div :class="['flex', direction, justify, align, classes]" :style="computedStyle">
        <div v-for="(item, index) in components" :key="item.id">
            <!-- Directly render the dynamically imported component -->
            <component :is="item.dynamicComponent" v-bind="item.props" />
        </div>
    </div>
</template>