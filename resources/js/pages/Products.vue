<script setup lang="ts">
// import AppHeader from '@/components/app/AppHeader.vue';
import ProductCard from '@/components/app/AppProductCard.vue';
import AppSpecialOfferBanner from '@/components/app/AppSpecialOfferBanner.vue';
import { Button } from '@/components/ui/button';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import AppMainLayout from '@/layouts/AppMainLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

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

interface Category {
    id: number;
    name: string;
    slug: string;
}

interface ProductsResponse {
    data: Product[];
    current_page: number;
    last_page: number;
    next_page_url: string | null;
    prev_page_url: string | null;
    total: number;
}

const props = defineProps<{
    products: ProductsResponse;
    categories: Category[];
    selectedCategory?: string;
    randomSpecialOffer: Product | null;
    showSpecialOfferBanner: boolean;
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

const loading = ref(false);
const selectedCategory = ref(props.selectedCategory || '');

const navigateToPage = async (url: string | null) => {
    if (!url || loading.value) return;

    loading.value = true;

    try {
        await router.get(
            url,
            {},
            {
                preserveScroll: true,
                preserveState: true,
                onFinish: () => {
                    loading.value = false;
                    // Scroll to top of product grid
                    window.scrollTo({
                        top: 500,
                        behavior: 'smooth',
                    });
                },
            },
        );
    } catch (error) {
        loading.value = false;
    }
};

const filterByCategory = async (slug: string) => {
    selectedCategory.value = slug;
    await router.get(
        '/',
        {
            category: slug || undefined,
        },
        {
            preserveScroll: true,
            preserveState: true,
        },
    );
};

const visiblePages = computed(() => {
    const current = props.products.current_page;
    const last = props.products.last_page;
    const delta = 2;
    const range = [];

    for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
        range.push(i);
    }

    if (current - delta > 2) {
        range.unshift('...');
    }

    if (current + delta < last - 1) {
        range.push('...');
    }

    range.unshift(1);
    if (last !== 1) range.push(last);

    return range;
});
</script>

<template>
    <div>
        <Head title="Products">
            <link rel="preconnect" href="https://rsms.me/" />
            <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        </Head>

        <!-- <AppHeader :categories="props.categories" :auth="auth" :cartItemCount="cartItemCount"></AppHeader> -->
        <AppMainLayout :categories="props.categories" :auth="props.auth" :cartItemCount="props.cartItemCount">
            <h1 class="mb-8 text-3xl font-bold">Our Products</h1>

            <AppSpecialOfferBanner v-if="showSpecialOfferBanner" :product="randomSpecialOffer" />

            <!-- Category Buttons Row -->
            <ScrollArea class="mb-8 w-full whitespace-nowrap">
                <div class="flex space-x-2 pb-4">
                    <Button @click="filterByCategory('')" :variant="selectedCategory === '' ? 'default' : 'outline'" class="rounded-full">
                        All Categories
                    </Button>

                    <Button
                        v-for="category in categories"
                        :key="category.id"
                        @click="filterByCategory(category.slug)"
                        :variant="selectedCategory === category.slug ? 'default' : 'outline'"
                        class="rounded-full"
                    >
                        {{ category.name }}
                    </Button>
                </div>
                <ScrollBar orientation="horizontal" />
            </ScrollArea>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <ProductCard v-for="product in products.data" :key="product.id" :product="product" />
            </div>

            <div class="mt-8 flex flex-col items-center justify-between gap-4 sm:flex-row">
                <div class="text-muted-foreground text-sm">
                    Showing page {{ products.current_page }} of {{ products.last_page }} ({{ products.total }} total products)
                </div>

                <div class="flex items-center gap-1">
                    <Button
                        @click="navigateToPage(products.prev_page_url)"
                        :disabled="!products.prev_page_url || loading"
                        variant="outline"
                        size="sm"
                    >
                        Previous
                    </Button>

                    <template v-for="(page, index) in visiblePages" :key="index">
                        <Button v-if="page === '...'" variant="ghost" size="sm" disabled class="cursor-default">
                            {{ page }}
                        </Button>
                        <Button
                            v-else
                            @click="navigateToPage(`?page=${page}`)"
                            :variant="products.current_page === page ? 'default' : 'outline'"
                            size="sm"
                        >
                            {{ page }}
                        </Button>
                    </template>

                    <Button
                        @click="navigateToPage(products.next_page_url)"
                        :disabled="!products.next_page_url || loading"
                        variant="outline"
                        size="sm"
                    >
                        Next
                    </Button>
                </div>
            </div>
        </AppMainLayout>
    </div>
</template>
