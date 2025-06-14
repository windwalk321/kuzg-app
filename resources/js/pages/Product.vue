<script setup lang="ts">
import AppProductCard from '@/components/app/AppProductCard.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import AppMainLayout from '@/layouts/AppMainLayout.vue';
import type { Category } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps<{
    product: {
        id: number;
        name: string;
        description: string;
        price: number;
        stock: number;
        image_url: string;
        is_special_offer: boolean;
        offer_expires_at: string | null;
        category: {
            id: number;
            name: string;
            slug: string;
        };
    };
    relatedProducts: Array<{
        id: number;
        name: string;
        price: number;
        image_url: string;
        is_special_offer: boolean;
    }>;
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
}>();

const quantity = ref(1);
const selectedImage = ref(props.product.image_url);

const addToCart = () => {
    router.post(
        route('cart.add', { product: props.product.id }),
        {
            quantity: quantity.value,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                // toast.success('Product added to cart');
            },
            onError: (errors) => {
                // toast.error('Failed to add product to cart');
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

const isOutOfStock = computed(() => props.product.stock <= 0);
const discountPrice = computed(() => formatPrice(props.product.price * 1.2));
const savingsAmount = computed(() => formatPrice(props.product.price * 0.2));
</script>

<template>
    <Head :title="product.name" />

    <AppMainLayout :categories="props.categories" :auth="props.auth" :cartItemCount="props.cartItemCount">
        <!-- Breadcrumbs -->
        <nav class="mb-6 flex items-center space-x-2 text-sm text-gray-600">
            <Link :href="route('products.index')" class="hover:text-primary hover:underline">Products</Link>
            <span>/</span>
            <Link :href="route('products.index', { category: product.category.slug })" class="hover:text-primary hover:underline">
                {{ product.category.name }}
            </Link>
            <span>/</span>
            <span class="text-gray-900">{{ product.name }}</span>
        </nav>

        <!-- Product Section -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <!-- Product Images -->
            <div class="space-y-4">
                <div class="mh-64 overflow-hidden rounded-lg bg-white shadow-sm">
                    <img :src="selectedImage" :alt="product.name" class="h-full max-h-[480px] w-full object-cover" />
                </div>
            </div>

            <!-- Product Details -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ product.name }}
                    </h1>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <Badge variant="secondary" class="text-sm">{{ product.category.name }}</Badge>
                        <Badge v-if="product.is_special_offer" variant="destructive" class="text-sm"> Special Offer </Badge>
                        <Badge v-if="isOutOfStock" variant="outline" class="text-sm"> Out of Stock </Badge>
                        <Badge v-else class="bg-green-100 text-sm text-green-800"> In Stock </Badge>
                    </div>
                </div>

                <!-- Price Section -->
                <div class="space-y-2">
                    <div class="flex items-baseline gap-3">
                        <span class="text-3xl font-bold text-gray-900">
                            {{ formatPrice(product.price) }}
                        </span>
                        <span v-if="product.is_special_offer" class="text-sm text-gray-500 line-through">
                            {{ discountPrice }}
                        </span>
                        <span v-if="product.is_special_offer" class="text-sm font-medium text-red-600"> Save {{ savingsAmount }} </span>
                    </div>
                    <p v-if="product.is_special_offer && product.offer_expires_at" class="text-sm text-gray-500">
                        Offer ends {{ new Date(product.offer_expires_at).toLocaleDateString() }}
                    </p>
                </div>

                <!-- Description -->
                <div class="prose max-w-none text-gray-700">
                    <p>{{ product.description }}</p>
                </div>

                <!-- Stock Info -->
                <div class="rounded-lg bg-gray-50 p-4">
                    <p class="text-sm font-medium">
                        <span v-if="product.stock > 5" class="text-green-600">In stock ({{ product.stock }} available)</span>
                        <span v-else-if="product.stock > 0" class="text-amber-600">Only {{ product.stock }} left in stock!</span>
                        <span v-else class="text-gray-500">Currently unavailable</span>
                    </p>
                    <p class="mt-1 text-xs text-gray-500">Free delivery on all orders over $50</p>
                </div>

                <!-- Add to Cart -->
                <div v-if="!isOutOfStock" class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center rounded-md border">
                            <Button variant="ghost" size="sm" @click="quantity > 1 ? quantity-- : null" :disabled="quantity <= 1"> - </Button>
                            <span class="w-10 text-center">{{ quantity }}</span>
                            <Button
                                variant="ghost"
                                size="sm"
                                @click="quantity < product.stock ? quantity++ : null"
                                :disabled="quantity >= product.stock"
                            >
                                +
                            </Button>
                        </div>
                        <Button @click="addToCart" class="flex-1" size="lg"> Add to Cart </Button>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="text-sm text-gray-500">
                    <p class="border-t pt-4">SKU: PROD-{{ product.id.toString().padStart(4, '0') }}</p>
                    <p class="mt-2">Category: {{ product.category.name }}</p>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <section v-if="relatedProducts.length > 0" class="mt-16">
            <h2 class="mb-6 text-2xl font-bold text-gray-900">You might also like</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <AppProductCard
                    v-for="relatedProduct in relatedProducts"
                    :key="relatedProduct.id"
                    :product="relatedProduct"
                    class="transition-shadow hover:shadow-md"
                />
            </div>
        </section>
    </AppMainLayout>
</template>
