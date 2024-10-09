<script setup lang="ts">
    import '@shared/assets/css/style.css';
    import '@shared/assets/css/variables.css';

    import { useQueryProvider } from 'vue-query';
    import { VueQueryDevTools } from 'vue-query/devtools';

    useQueryProvider();
</script>

<template>
    <RouterView />

    <VueQueryDevTools />
</template>
