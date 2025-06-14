<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import AppMainLayout from '@/layouts/AppMainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    orders: Array<{
        order_number: string;
        status: string;
        total: number;
        created_at: string;
        items: Array<{
            quantity: number;
            price: number;
            product: {
                name: string;
                image: string;
            };
        }>;
    }>;
    categories: Array<{
        id: number;
        name: string;
        slug: string;
    }>;
    auth: {
        user?: {
            first_name: string;
            last_name: string;
            email: string;
            avatar?: string;
        };
    };
    cartItemCount?: number;
}>();
</script>

<template>
    <Head title="My Profile" />

    <AppMainLayout :categories="categories" :auth="auth" :cartItemCount="cartItemCount">
        <div class="container mx-auto px-4 py-8">
            <h1 class="mb-8 text-3xl font-bold tracking-tight text-gray-900">My Profile</h1>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- User Info -->
                <div class="lg:col-span-1">
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-xl">Account Information</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium">{{ auth.user?.first_name }} {{ auth.user?.last_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ auth.user?.email }}</p>
                            </div>
                        </CardContent>
                        <CardFooter>
                            <Button variant="outline" class="w-full" as-child>
                                <Link :href="route('profile.edit')">Edit Profile</Link>
                            </Button>
                        </CardFooter>
                    </Card>
                </div>

                <!-- Orders -->
                <div class="lg:col-span-2">
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-xl">My Orders</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div v-if="orders.length === 0" class="py-8 text-center">
                                <p class="text-gray-500">You haven't placed any orders yet.</p>
                                <Button as-child class="mt-4">
                                    <Link :href="route('products.index')">Browse Products</Link>
                                </Button>
                            </div>

                            <div v-else class="space-y-6">
                                <div v-for="order in orders" :key="order.order_number" class="border-b pb-6 last:border-b-0">
                                    <div class="mb-4 flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">Order #{{ order.order_number }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ new Date(order.created_at).toLocaleDateString() }}
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <Badge variant="outline" class="capitalize">{{ order.status }}</Badge>
                                            <p class="font-medium">${{ order.total.toFixed(2) }}</p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div v-for="(item, index) in order.items.slice(0, 2)" :key="index" class="flex items-center gap-4">
                                            <img :src="`storage/${item.product.image}`" class="h-12 w-12 rounded-md border object-cover" />
                                            <div>
                                                <p class="font-medium">{{ item.product.name }}</p>
                                                <p class="text-sm text-gray-500">Qty: {{ item.quantity }}</p>
                                            </div>
                                        </div>

                                        <p v-if="order.items.length > 2" class="text-sm text-gray-500">+ {{ order.items.length - 2 }} more items</p>

                                        <Button variant="outline" size="sm" as-child>
                                            <Link :href="route('order.confirmation', order.id)">View Order</Link>
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppMainLayout>
</template>
