<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Return from '@/Icons/Return.vue';

defineProps( ['title', 'back'] );

const back = () => {
    window.history.back();
}
</script>

<template>
    <div class="flex flex-row items-center">
        <!-- Back button -->
        <SecondaryButton v-if="back" class="me-3" @click="back()">
            <Return class="w-5" />
        </SecondaryButton>

        <!-- Title -->
        <div class="flex-grow">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <span>{{ title }}</span>
            </h2>
        </div>

        <slot name="action" />
    </div>
</template>