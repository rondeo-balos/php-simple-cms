<script setup>
import { Head } from '@inertiajs/vue3'

defineProps({ title: String })
</script>

<template>
  <Head :title="title ? `${title} - Simpl.CMS` : 'Simpl.CMS'">
    <slot />
  </Head>
</template>