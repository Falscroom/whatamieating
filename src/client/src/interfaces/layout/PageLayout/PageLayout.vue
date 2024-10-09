<script setup lang="ts">
    import {Header} from '@interfaces/components';
</script>

<template>
    <div class="page-layout">
        <Header />
        <slot />
    </div>
</template>

<style scoped>
.page-layout {
    padding: 0 var(--gutter);
}
</style>
