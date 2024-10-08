<script setup lang="ts">
    interface Props {
        name: string
    }

    defineProps<Props>();
</script>

<template>
    <RouterLink to="/whatIamEating" class="user-card">
        {{ name }}
    </RouterLink>
</template>

<style scoped>
.user-card {
    display: block;
    padding: calc(var(--gutter) * 2) calc(var(--gutter) * 3);
    background-color: var(--slate-200);
    border-radius: var(--border-radius);
}
</style>
