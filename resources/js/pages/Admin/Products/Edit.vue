<script setup lang="ts">
import AppProductForm from '@/components/app/AppProductForm.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    product: {
        id: number;
        name: string;
        description: string;
        price: number;
        stock: number;
        image_url: string;
        category_id: number;
        is_special_offer: boolean;
        offer_expires_at: string | null;
    };
    categories: {
        id: number;
        name: string;
    }[];
}>();

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    stock: props.product.stock,
    category_id: props.product.category_id,
    is_special_offer: props.product.is_special_offer,
    offer_expires_at: props.product.offer_expires_at,
    image: null,
});

const loading = ref(false);

const submit = (values: any) => {
    loading.value = true;
    form.transform((data) => ({
        ...data,
        price: parseFloat(data.price),
        stock: parseInt(data.stock),
        _method: 'put',
    })).post(route('admin.products.update', props.product.id), {
        onFinish: () => {
            loading.value = false;
        },
    });
};
</script>

<template>
    <Head title="Edit Product" />

    <AdminLayout>
        <div class="p-6">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Edit Product</h1>
                <Button asChild variant="outline">
                    <Link :href="route('admin.products.index')">Back to Products</Link>
                </Button>
            </div>

            <div class="rounded-md border bg-white p-6 shadow-sm">
                <AppProductForm :product="product" :categories="categories" @submit="submit" :loading="loading" />
            </div>
        </div>
    </AdminLayout>
</template>
