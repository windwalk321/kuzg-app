<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Link, router } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
    price: number;
    image_url: string;
    is_special_offer: boolean;
    offer_expires_at?: string | null; // Added for countdown
}

interface Props {
    product: Product | null;
}

const props = defineProps<Props>();
const product = props.product;

const addToCart = () => {
    if (!product) return;
    router.post(
        route('cart.add', { product: product.id }),
        {
            quantity: 1,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                // Optional: Show toast notification
            },
        },
    );
};

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(price);
};

// const calculateDiscountPercentage = (currentPrice: number, originalPrice?: number) => {
//     if (!originalPrice) return 0;
//     return Math.round(((originalPrice - currentPrice) / originalPrice) * 100);
// };

const daysRemaining = (expiryDate: string | null | undefined) => {
    if (!expiryDate) return null;
    const now = new Date();
    const expiry = new Date(expiryDate);
    const diffTime = expiry.getTime() - now.getTime();
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
};
</script>

<template>
    <div
        v-if="product"
        class="group relative mb-6 overflow-hidden rounded-xl border border-rose-100 bg-gradient-to-br from-rose-50 to-pink-50 shadow-md transition-all duration-300 hover:shadow-lg"
    >
        <!-- Ribbon Corner -->
        <div class="absolute -top-8 -right-8 h-16 w-32 rotate-45 bg-rose-600">
            <span class="absolute top-8 left-0 w-full text-center text-xs font-bold text-white"> SPECIAL OFFER </span>
        </div>

        <div class="flex items-center p-5">
            <!-- Product Image -->
            <div class="relative mr-5 h-24 w-24 shrink-0 overflow-hidden rounded-lg bg-white shadow-sm">
                <img
                    :src="product.image_url"
                    :alt="product.name"
                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                />
                <Badge variant="destructive" class="absolute -top-2 -right-2 z-10 px-2 py-0.5 text-xs font-bold shadow-sm">
                    <!-- {{ calculateDiscountPercentage(product.price, product.original_price) }}% OFF -->
                    20% OFF
                </Badge>
            </div>

            <!-- Product Details -->
            <div class="flex-1 overflow-hidden">
                <div class="mb-2 flex items-baseline gap-2">
                    <h3 class="truncate text-lg font-bold text-gray-900">{{ product.name }}</h3>
                </div>

                <!-- Price Section -->
                <div class="mb-3 flex items-baseline gap-2">
                    <p class="text-2xl font-bold text-rose-600">{{ formatPrice(product.price) }}</p>
                    <p v-if="product.original_price" class="text-sm text-gray-500 line-through">
                        {{ formatPrice(product.original_price) }}
                    </p>
                </div>

                <!-- Countdown (if available) -->
                <div v-if="product.offer_expires_at" class="mb-3 text-xs text-rose-800">
                    <span class="font-semibold">⏰ Ends in {{ daysRemaining(product.offer_expires_at) }} days</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <Button as-child variant="outline" class="h-9 rounded-lg px-4 hover:bg-rose-50 hover:text-rose-600">
                        <Link :href="`/products/${product.id}`">View Details</Link>
                    </Button>
                    <Button @click="addToCart" class="h-9 rounded-lg bg-rose-600 px-4 text-white hover:bg-rose-700 focus-visible:ring-rose-300">
                        <span>Add to Cart</span>
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
