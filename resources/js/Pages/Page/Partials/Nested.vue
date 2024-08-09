<script setup>
import { computed, ref } from 'vue';
import draggable from 'vuedraggable';

const props = defineProps({
    list: {
        required: true,
        type: Array
    }
});

const emit = defineEmits(['update:list']);

const updateList = (newList) => {
    emit('update:list', newList);
};

//const listProp = ref(props.list);

const dragOptions = computed(() => {
    return {
        animation: 100,
      };
});
</script>

<template>
    <draggable :list="list" group="container" item-key="id" v-bind="dragOptions" @update:modelValue="updateList">
        <template #item="{element}">
            <div>
                <div class="rounded border shadow-sm m-2 p-2 w-52 bg-gray-700 text-white">{{ element.name }}</div>
                <Nested v-if="element.nested" :class="{ 'ms-6': element.nested }" :list="element.list" @update:list="newList => updateList(newList)" />
            </div>
        </template>
    </draggable>
</template>