<script setup lang="ts">
import AppDataTable from '@/components/app/AppDataTable/DataTable.vue';
import AppHeader from '@/components/app/AppHeader.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

interface User {
    id: string;
    first_name: string;
    last_name: string;
    role: string;
    email: string;
}

const props = defineProps<{
    users: {
        data: Array<User>;
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    };
    auth: {
        user: User;
    };
}>();

const isLoading = ref(false);

const handlePageChange = async (page: number) => {
    isLoading.value = true;
    await router.get(
        route('dashboard'),
        { page },
        {
            preserveState: true,
            replace: true,
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
};
</script>

<template>
    <Head title="Dashboard" />
    <AppHeader></AppHeader>
    <main class="fle-col flex min-h-screen justify-center">
        <div class="flex w-7xl flex-col">
            <AppDataTable
                :auth="props.auth"
                :pagination="{
                    current_page: props.users.current_page,
                    per_page: props.users.per_page,
                    total: props.users.total,
                    last_page: props.users.last_page,
                }"
                @page-change="handlePageChange"
                :data="users.data"
                :loading="isLoading"
            ></AppDataTable>
        </div>
    </main>
</template>
