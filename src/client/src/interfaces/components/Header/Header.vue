<script setup lang="ts">
    import Button from 'primevue/button';
    import {router} from '@interfaces/router';

    const goBack = () => {
        router.back();
    }
</script>

<template>
    <header class="header">
        <Button @click="goBack">{{ $t('system.goBack') }}</Button>
    </header>
</template>

<style scoped>
.header {
    padding: var(--gutter) 0;
}
</style>
