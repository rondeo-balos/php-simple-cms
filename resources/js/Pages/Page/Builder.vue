<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Nested from './Partials/Nested.vue';
import { ref } from 'vue';

let items = ref([
    {
        name: 'image',
        id: '123'
    },
    {
        name: 'text',
        id: '1232'
    },
    {
        name: 'container2',
        id: '2134444',
        nested: true,
        list: []
    },
    {
        name: 'container',
        id: '1223',
        nested: true,
        list: [
            {
                name: 'yeah',
                id: '11123'
            }
        ]
    }
]);

const addComponent = (name) => {
    items.value.push({ name });
    console.log( items.value );
};

const save = () => {
    console.log( JSON.stringify(items.value, null, 2) );
};
</script>

<template>
    <div>
        
        <div class="border shadow p-1 m-2 inline-block bg-slate-50 rounded">
            <Nested :list="items" />
        </div>
    </div>

    <!--<PrimaryButton @click="save">Save</PrimaryButton>-->
</template>