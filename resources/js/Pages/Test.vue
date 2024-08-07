<script setup>
import { defineAsyncComponent } from 'vue';

const dynamicComponent = defineAsyncComponent(() => import(`../Components/${'PrimaryButton'}.vue`));
</script>

<template>
    <component :is="dynamicComponent">Test</component>
</template>