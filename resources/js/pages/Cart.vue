<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppMainLayout from '@/layouts/AppMainLayout.vue';
import type { Cart, CartItem } from '@/types/cart';
import { Head, Link, router } from '@inertiajs/vue3';
import { ChevronLeft, RefreshCw, ShieldCheck, ShoppingCart, Truck, X } from 'lucide-vue-next';
import { computed } from 'vue';

defineProps<{
    cart: Cart;
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

const updateQuantity = (item: CartItem, quantity: number) => {
    const newQuantity = Math.max(1, Math.min(quantity, item.product.stock));
    if (newQuantity !== item.quantity) {
        router.put(route('cart.update', { itemId: item.id }), { quantity: newQuantity }, { preserveScroll: true });
    }
};

const removeItem = (item: CartItem) => {
    router.delete(route('cart.remove', { itemId: item.id }), {
        preserveScroll: true,
        onSuccess: () => {
            // Optional: Show toast notification
        },
    });
};

const estimatedDelivery = computed(() => {
    const now = new Date();
    const deliveryDate = new Date(now.setDate(now.getDate() + 3));
    return deliveryDate.toLocaleDateString('en-US', {
        weekday: 'long',
        month: 'short',
        day: 'numeric',
    });
});
</script>

<template>
    <Head title="Cart">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <AppMainLayout :categories="categories" :auth="auth" :cartItemCount="cartItemCount">
        <!-- Header and Continue Shopping -->
        <div class="mb-8">
            <Button variant="ghost" as-child class="mb-4">
                <Link :href="route('products.index')" class="flex items-center gap-2">
                    <ChevronLeft class="h-4 w-4" />
                    Continue Shopping
                </Link>
            </Button>

            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Shopping Cart</h1>
            <p class="mt-2 text-sm text-gray-500" v-if="cart.items.length > 0">
                {{ cart.items.reduce((acc, item) => acc + item.quantity, 0) }} items in your cart
            </p>
        </div>

        <!-- Empty Cart State -->
        <div v-if="cart.items.length === 0" class="rounded-lg border-2 border-dashed border-gray-200 bg-gray-50 py-16 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                <ShoppingCart class="h-6 w-6 text-gray-500" />
            </div>
            <h3 class="mb-1 text-lg font-medium text-gray-900">Your cart is empty</h3>
            <p class="mb-6 text-gray-500">Start adding some items to your cart</p>
            <Button as-child>
                <Link :href="route('products.index')" class="gap-2">
                    <ShoppingCart class="h-4 w-4" />
                    Browse Products
                </Link>
            </Button>
        </div>

        <!-- Cart with Items -->
        <div v-else class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Cart Items List -->
            <div class="space-y-4 lg:col-span-2">
                <Card v-for="item in cart.items" :key="item.id" class="relative overflow-hidden">
                    <!-- Special Offer Badge -->
                    <Badge v-if="item.product.is_special_offer" variant="destructive" class="absolute top-4 left-0 rounded-r-md">
                        Special Offer
                    </Badge>

                    <CardHeader class="flex flex-row items-center justify-between pb-2">
                        <CardTitle class="text-lg font-medium">
                            <Link :href="route('product', item.product.id)" class="hover:underline hover:underline-offset-4">
                                {{ item.product.name }}
                            </Link>
                        </CardTitle>
                        <Button variant="ghost" size="sm" @click="removeItem(item)" class="text-destructive hover:bg-destructive/10">
                            <X class="h-4 w-4" />
                        </Button>
                    </CardHeader>

                    <CardContent>
                        <div class="grid grid-cols-1 items-center gap-6 md:grid-cols-3">
                            <!-- Product Image -->
                            <div class="flex items-center">
                                <img
                                    :src="`storage/${item.product.image_url}`"
                                    :alt="item.product.name"
                                    class="h-24 w-24 rounded-md border object-cover"
                                />
                            </div>

                            <!-- Quantity Controls -->
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <Button
                                        variant="outline"
                                        size="sm"
                                        @click="updateQuantity(item, item.quantity - 1)"
                                        :disabled="item.quantity <= 1"
                                    >
                                        -
                                    </Button>
                                    <Input
                                        type="number"
                                        :modelValue="item.quantity"
                                        @update:modelValue="(val) => updateQuantity(item, Number(val))"
                                        :min="1"
                                        :max="item.product.stock"
                                        class="w-16 text-center"
                                    />
                                    <Button
                                        variant="outline"
                                        size="sm"
                                        @click="updateQuantity(item, item.quantity + 1)"
                                        :disabled="item.quantity >= item.product.stock"
                                    >
                                        +
                                    </Button>
                                </div>
                                <p class="text-muted-foreground text-xs">
                                    <span v-if="item.product.stock > 5">{{ item.product.stock }} available</span>
                                    <span v-else class="text-amber-600">Only {{ item.product.stock }} left!</span>
                                </p>
                            </div>

                            <!-- Price -->
                            <div class="flex flex-col items-end space-y-1">
                                <span class="text-lg font-semibold">
                                    {{ (item.product.price * item.quantity).toFixed(2) }}
                                </span>
                                <span class="text-muted-foreground text-sm"> {{ item.product.price }} each </span>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Order Summary -->
            <div class="space-y-4">
                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Order Summary</CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="flex justify-between">
                            <span>Subtotal ({{ cart.items.reduce((acc, item) => acc + item.quantity, 0) }} items)</span>
                            <span class="font-medium">${{ cart.total.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="font-medium text-green-600">FREE</span>
                        </div>
                        <div class="flex justify-between border-t pt-4 text-lg font-bold">
                            <span>Total</span>
                            <span>${{ cart.total.toFixed(2) }}</span>
                        </div>
                    </CardContent>
                    <CardFooter class="flex-col space-y-4">
                        <Button class="w-full" size="lg" as-child>
                            <Link :href="route('checkout')">Proceed to Checkout</Link>
                        </Button>
                        <Button variant="outline" class="w-full" size="lg" as-child>
                            <Link :href="route('products.index')">Continue Shopping</Link>
                        </Button>
                    </CardFooter>
                </Card>

                <!-- Order Benefits -->
                <Card class="bg-gray-50">
                    <CardContent class="space-y-4 pt-6">
                        <div class="flex items-start gap-4">
                            <Truck class="mt-0.5 h-5 w-5 text-gray-500" />
                            <div>
                                <p class="font-medium">Free Delivery</p>
                                <p class="text-muted-foreground text-sm">Estimated by {{ estimatedDelivery }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <ShieldCheck class="mt-0.5 h-5 w-5 text-gray-500" />
                            <div>
                                <p class="font-medium">Easy Returns</p>
                                <p class="text-muted-foreground text-sm">30-day return policy</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <RefreshCw class="mt-0.5 h-5 w-5 text-gray-500" />
                            <div>
                                <p class="font-medium">Price Match</p>
                                <p class="text-muted-foreground text-sm">Found it cheaper? We'll match it</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppMainLayout>
</template>
