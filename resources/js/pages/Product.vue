<script setup lang="ts">
import AppFooter from '@/components/app/AppFooter.vue';
import AppHeader from '@/components/app/AppHeader.vue';
import AppProductsGrid from '@/components/app/AppProductsGrid.vue';
import AppProductsItem from '@/components/app/AppProductsItem.vue';
import Button from '@/components/ui/button/Button.vue';
import { Head } from '@inertiajs/vue3';
import { CalendarCheck, ShoppingBasket, Star } from 'lucide-vue-next';
import { ref } from 'vue';

const product = {
    id: 1,
    name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
    price: 34.99,
    imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
    rating: 5,
    dateStarted: '1 year ago',

    description:
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
};

const recomended = ref([
    {
        id: 1,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 2,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 3,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 4,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 5,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 6,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 7,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 8,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 9,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 10,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 11,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 12,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 13,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 14,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
    {
        id: 15,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
]);

const ratingArray = (length: number) => {
    return Array.from({ length }, (_, i) => i + 1);
};
</script>

<template>
    <Head title="Product" />
    <AppHeader />
    <main class="fle-col flex justify-center">
        <div class="flex w-7xl flex-col">
            <h2 class="text-2xl font-bold">Details</h2>
            <Separator orientation="horizontal" class="my-4 h-px w-full bg-gray-300"></Separator>
            <div class="container flex">
                <div class="flex w-lg">
                    <img :src="product.imageUrl" :alt="product.name" />
                </div>
                <div class="ml-auto w-xl">
                    <h1>{{ product.name }}</h1>
                    <span class="mt-4 inline-block">{{ product.price }} USD</span>
                    <div class="mt-4 flex">
                        <Star color="orange" v-for="n in ratingArray(product.rating)" :key="n"></Star>
                        <span class="ml-1 text-gray-500">5</span>
                    </div>
                    <div class="mt-4 flex items-center">
                        <CalendarCheck color="green"></CalendarCheck>
                        <span class="text-bold ml-1 text-sm font-bold">Started to sell on YARMAROK 1 year ago</span>
                    </div>
                    <p class="mt-8 inline-block">{{ product.description }}</p>
                    <Button class="mt-5 w-full cursor-pointer">
                        <span>Add to cart</span>
                        <ShoppingBasket></ShoppingBasket>
                    </Button>
                </div>
            </div>
            <div class="mt-20">
                <h2 class="text-2xl font-black">Recommended</h2>
                <span class="text-md text-gray-500">You may also like</span>
                <AppProductsGrid class="mt-10">
                    <AppProductsItem v-for="item in recomended" :key="item.id" :item="{ ...item }"> </AppProductsItem>
                </AppProductsGrid>
            </div>
        </div>
    </main>
    <AppFooter />
</template>
