<script setup>
import DataTable from '@/Pages/DataTable/Index.vue';
import { onMounted, ref } from 'vue';

const props = defineProps({
    title: {
        type: String
    },
    add: {
        type: String
    },
    per_page: {
        type: String
    },
    s: {
        type: String
    },
    columns: {
        type: Array
    },
    data: {
        type: Object
    },
    collection: {
        type: String
    }
});

console.log( props.data );

const localColumns = ref([...props.columns]);
const localData = ref(JSON.parse(JSON.stringify(props.data)));

onMounted( async () => {
    try {
        const collectionModules = import.meta.glob( '../../Public/Collections/*.js' );
        const collectionPath = `../../Public/Collections/${props.collection}.js`;

        if( collectionModules[collectionPath] ) {
            const module = await collectionModules[collectionPath]();
            let keys = module.default.columns;

            localColumns.value = [ 'id', ...keys ];
            
            props.data.data.map( (item, key) => {
                localData.value.data[key] = {
                    ...item,
                    ...JSON.parse( item.value )
                };
            });
        }
    } catch( error ) {
        console.error( 'Error loading collection options: ', error );
    }
});

</script>

<template>
    <DataTable :title="title" :add="add" :per_page="per_page" :s="s" :columns="localColumns" :data="localData" />
</template>