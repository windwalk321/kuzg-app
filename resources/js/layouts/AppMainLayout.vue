<script setup lang="ts">
import AppFooter from '@/components/app/AppFooter.vue';
import AppHeader from '@/components/app/AppHeader.vue';
import type { BreadcrumbItemType, Category } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    categories: Category[];
    cartItemCount?: number;
    auth: {
        user?: {
            first_name: string;
            last_name: string;
            email: string;
            avatar?: string;
        };
    };
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <div class="flex min-h-screen w-full flex-col" :breadcrumbs="breadcrumbs">
        <AppHeader :categories="props.categories" :auth="auth" :cartItemCount="cartItemCount"></AppHeader>
        <div class="container mx-auto px-4 py-8">
            <slot />
        </div>
        <AppFooter />
    </div>
</template>
