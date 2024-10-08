<script setup lang="ts">
    import {UserCard} from '@interfaces/components';
    import {useUserQuery} from '@infrastructure/persistence';
    import UserViewSkeleton from '@interfaces/views/UserView/UserViewSkeleton.vue';

    const {data: users, isLoading} = useUserQuery();
</script>

<template>
    <div class="login-page">
        <UserViewSkeleton v-if="isLoading" />
        <template v-else>
            <h1 class="login-page__title">{{ $t('login.PageTitle') }}</h1>

            <ul class="login-page__users login-page-users">
                <li v-for="user in users" :key="`use--${user.id}`" class="login-page-user__item">
                    <UserCard :name="user.name" />
                </li>
            </ul>
        </template>
    </div>
</template>

<style scoped>
.login-page__title {
    display: flex;
    justify-content: center;
    margin-bottom: calc(var(--gutter) * 2);
    margin-top: var(--gutter);
    color: var(--base-clr);
}

.login-page__users {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: var(--gutter);
}

.login-page-user__item {
    width: 100%;
    max-width: 300px;
}
</style>
