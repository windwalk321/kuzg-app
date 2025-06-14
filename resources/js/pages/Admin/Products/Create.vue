<script setup lang="ts">
import AppProductForm from '@/components/app/AppProductForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    categories: {
        id: number;
        name: string;
    }[];
}>();

const form = useForm({
    name: '',
    description: '',
    price: 0,
    stock: 0,
    category_id: undefined,
    is_special_offer: false,
    offer_expires_at: null,
    image: null,
});

const loading = ref(false);

// const submit = (values: any) => {
//     loading.value = true;
//     form.transform((data) => ({
//         ...data,
//         price: parseFloat(data.price),
//         stock: parseInt(data.stock),
//     })).post(route('admin.products.store'), {
//         onFinish: () => {
//             loading.value = false;
//         },
//     });
// };

const submit = (formData: FormData) => {
    loading.value = true;

    // Use Inertia's post method with FormData
    router.post(route('admin.products.store'), formData, {
        onSuccess: () => {
            // Handle success
        },
        onError: (errors) => {
            // Handle errors
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};
</script>

<template>
    <Head title="Create Product" />

    <AdminLayout>
        <div class="p-6">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Create Product</h1>
                <Button asChild variant="outline">
                    <Link :href="route('admin.products.index')">Back to Products</Link>
                </Button>
            </div>

            <div class="rounded-md border bg-white p-6 shadow-sm">
                <AppProductForm :categories="categories" @submit="submit" :loading="loading" />
            </div>
        </div>
    </AdminLayout>
</template>
