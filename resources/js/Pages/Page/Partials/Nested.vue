<script setup>
import { computed } from 'vue';
import draggable from 'vuedraggable';
import Pen from '@/Icons/Pen.vue';
import Trash from '@/Icons/Trash.vue';

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
                <div :data-id="element.id" class="rounded shadow-sm my-1 p-2 w-full bg-gray-300 dark:bg-gray-700 dark:text-white cursor-pointer focus:cursor-move hover:bg-slate-300 dark:hover:bg-slate-600 flex flex-row items-center gap-2 group">
                    <span class="flex-grow" @click="element.edit()">{{ element.name }}</span>
                    <Pen class="w-5 h-5 cursor-pointer fill-white opacity-0 group-hover:opacity-100 transition-opacity" @click="element.edit()"/>
                    <Trash class="w-5 h-5 cursor-pointer fill-white opacity-0 group-hover:opacity-100 transition-opacity" @click="element.delete()" />
                </div>
                <Nested v-if="element.nested" :class="{ 'ms-4': element.nested }" :list="element.props.list" @update:list="newList => updateList(newList)" />
            </div>
        </template>
    </draggable>
</template>