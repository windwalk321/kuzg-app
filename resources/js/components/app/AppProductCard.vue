<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Link } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
    image_url: string;
    is_special_offer: boolean;
    offer_expires_at: string | null;
    category_id: number;
}

defineProps<{
    product: Product;
}>();

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(price);
};

const calculateDiscount = (price: number) => {
    return formatPrice(price * 1.2);
};

const daysRemaining = (expiryDate: string | null) => {
    if (!expiryDate) return null;
    const now = new Date();
    const expiry = new Date(expiryDate);
    const diffTime = expiry.getTime() - now.getTime();
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
};

const getStockStatus = (stock: number) => {
    if (stock <= 0) return { text: 'Out of Stock', class: 'bg-gray-500 text-gray-50' };
    if (stock <= 5) return { text: `Low Stock (${stock})`, class: 'bg-amber-500 text-amber-50' };
    return { text: 'In Stock', class: 'bg-green-500 text-green-50' };
};
</script>

<template>
    <Card class="flex h-full flex-col">
        <!-- Special Offer Badge -->
        <div
            v-if="product.is_special_offer"
            class="bg-destructive text-destructive-foreground absolute top-2 left-2 z-10 rounded-full px-3 py-1 text-xs font-medium"
        >
            {{ daysRemaining(product.offer_expires_at) ? `${daysRemaining(product.offer_expires_at)}d left` : 'Special Offer' }}
        </div>

        <Link :href="route('product', product.id)" class="flex flex-grow flex-col">
            <CardHeader class="p-0">
                <div class="relative aspect-square overflow-hidden rounded-t-lg">
                    <img :src="product.image_url" :alt="product.name" class="h-full w-full object-cover" loading="lazy" />
                </div>
            </CardHeader>

            <CardContent class="flex-grow space-y-2 pt-4">
                <CardTitle class="line-clamp-2 text-lg font-medium">
                    {{ product.name }}
                </CardTitle>

                <p class="text-muted-foreground mb-2 line-clamp-2 text-sm">
                    {{ product.description }}
                </p>

                <!-- Stock Status -->
                <div class="mb-2 text-xs">
                    <span :class="getStockStatus(product.stock).class" class="rounded-full px-2 py-1">
                        {{ getStockStatus(product.stock).text }}
                    </span>
                </div>

                <!-- Price Section -->
                <div class="mt-auto">
                    <div class="flex items-center gap-2">
                        <span class="text-foreground text-lg font-bold">
                            {{ formatPrice(product.price) }}
                        </span>
                        <span v-if="product.is_special_offer" class="text-muted-foreground text-sm line-through">
                            {{ calculateDiscount(product.price) }}
                        </span>
                    </div>
                    <div v-if="product.is_special_offer" class="text-destructive mt-1 text-xs">Save {{ formatPrice(product.price * 0.2) }}</div>
                </div>
            </CardContent>
        </Link>

        <CardFooter class="flex gap-2 pt-0">
            <Button as-child variant="outline">
                <Link :href="route('product', product.id)"> View Details </Link>
            </Button>
            <Button variant="default" :disabled="product.stock <= 0">
                {{ product.stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
            </Button>
        </CardFooter>
    </Card>
</template>
