<script setup lang="ts">
    import Skeleton from 'primevue/skeleton';
</script>

<template>
    <div class="user-view-skeleton">
        <Skeleton height="1.5rem" width="11rem" class="user-view-skeleton__title" />

        <Skeleton v-for="i in 5" :key="`user-view-skeleton-user--${i}`" height="2rem" class="user-view-skeleton__user" />
    </div>
</template>

<style scoped>
.user-view-skeleton {
    padding-top: var(--gutter);
    display: flex;
    flex-direction: column;
    align-items: center;
}

.user-view-skeleton__title {
    margin-bottom: calc(var(--gutter) * 2);
}

.user-view-skeleton__user:not(:last-child) {
    margin-bottom: var(--gutter);
}
</style>
