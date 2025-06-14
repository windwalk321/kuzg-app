<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import AppMainLayout from '@/layouts/AppMainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { CheckCircle2, ShoppingCart } from 'lucide-vue-next';

const props = defineProps<{
    order: {
        order_number: string;
        status: string;
        total: number;
        payment_method: string;
        payment_status: string;
        shipping_address: {
            first_name: string;
            last_name: string;
            address: string;
            city: string;
            state: string;
            zip_code: string;
            country: string;
        };
        items: Array<{
            id: number;
            quantity: number;
            price: number;
            product: {
                id: number;
                name: string;
                image_url: string;
            };
        }>;
        created_at: string;
    };
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
    <Head :title="`Order Confirmation #${order.order_number}`" />

    <AppMainLayout :categories="categories" :auth="auth" :cartItemCount="cartItemCount">
        <div class="container mx-auto px-4 py-12">
            <div class="mx-auto max-w-3xl">
                <!-- Confirmation Header -->
                <div class="mb-10 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                        <CheckCircle2 class="h-8 w-8 text-green-600" />
                    </div>
                    <h1 class="mb-2 text-3xl font-bold tracking-tight text-gray-900">Order Confirmed!</h1>
                    <p class="text-lg text-gray-600">
                        Thank you for your order <span class="font-medium">{{ order.shipping_address.first_name }}</span
                        >!
                    </p>
                    <p class="mt-2 text-gray-500">Your order number is #{{ order.order_number }}</p>
                </div>

                <!-- Order Summary -->
                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Order Summary</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <!-- Order Status -->
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Status</span>
                            <Badge variant="outline" class="capitalize">{{ order.status }}</Badge>
                        </div>

                        <!-- Payment Status -->
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Status</span>
                            <Badge variant="outline" class="capitalize">{{ order.payment_status }}</Badge>
                        </div>

                        <!-- Payment Method -->
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method</span>
                            <span class="font-medium capitalize">{{ order.payment_method.replace('_', ' ') }}</span>
                        </div>

                        <!-- Order Date -->
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Date</span>
                            <span class="font-medium">{{ new Date(order.created_at).toLocaleDateString() }}</span>
                        </div>

                        <!-- Shipping Address -->
                        <div>
                            <h3 class="mb-2 font-medium text-gray-900">Shipping Address</h3>
                            <address class="text-gray-600 not-italic">
                                {{ order.shipping_address.first_name }} {{ order.shipping_address.last_name }}<br />
                                {{ order.shipping_address.address }}<br />
                                {{ order.shipping_address.city }}, {{ order.shipping_address.state }} {{ order.shipping_address.zip_code }}<br />
                                {{ order.shipping_address.country }}
                            </address>
                        </div>

                        <!-- Order Items -->
                        <div>
                            <h3 class="mb-4 font-medium text-gray-900">Order Items</h3>
                            <div class="space-y-4">
                                <div v-for="item in order.items" :key="item.id" class="flex items-start gap-4">
                                    <img :src="item.product.image_url" :alt="item.product.name" class="h-16 w-16 rounded-md border object-cover" />
                                    <div class="flex-1">
                                        <p class="font-medium">{{ item.product.name }}</p>
                                        <p class="text-sm text-gray-500">Qty: {{ item.quantity }}</p>
                                    </div>
                                    <p class="font-medium">${{ (item.price * item.quantity).toFixed(2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Total -->
                        <div class="space-y-2 border-t pt-4">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>${{ order.total.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span class="text-green-600">FREE</span>
                            </div>
                            <div class="flex justify-between border-t pt-2 text-lg font-bold">
                                <span>Total</span>
                                <span>${{ order.total.toFixed(2) }}</span>
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter class="flex-col space-y-3">
                        <Button class="w-full" size="lg" as-child>
                            <Link :href="route('products.index')" class="flex items-center gap-2">
                                <ShoppingCart class="h-5 w-5" />
                                Continue Shopping
                            </Link>
                        </Button>
                        <!-- <Button variant="outline" class="w-full" size="lg" as-child>
                            <Link :href="route('home')" class="flex items-center gap-2">
                                <Home class="h-5 w-5" />
                                Back to Home
                            </Link>
                        </Button> -->
                    </CardFooter>
                </Card>
            </div>
        </div>
    </AppMainLayout>
</template>
