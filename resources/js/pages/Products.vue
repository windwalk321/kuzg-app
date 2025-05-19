<script setup lang="ts">
import AppFilters from '@/components/app/AppFilters.vue';
import AppFooter from '@/components/app/AppFooter.vue';
import AppHeader from '@/components/app/AppHeader.vue';
import AppProductsGrid from '@/components/app/AppProductsGrid.vue';
import AppProductsItem from '@/components/app/AppProductsItem.vue';
import Button from '@/components/ui/button/Button.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const goods = ref([
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

const updateGoods = () => {
    for (let i = 0; i < 15; i++) {
        const goodsLastId = goods.value[goods.value.length - 1].id;
        const newGoods = [
            {
                id: goodsLastId + 1,
                name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
                price: 34.99,
                imageUrl:
                    'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
                rating: 5,
                dateStarted: '1 year ago',
            },
        ];
        goods.value.push(...newGoods);
    }
};

const currentFilter = ref('recomended');
const setCurrentFilter = (filter: string) => {
    currentFilter.value = filter;
};
</script>

<template>
    <Head title="Products">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <AppHeader />
    <div class="flex h-64 justify-center bg-gray-200">
        <!-- <img
            class="w-7xl"
            src="https://aimg.kwcdn.com/material-put/2013f7735d0/14b2d017-75be-4a66-8075-08d95f791ba9.png?imageView2/q/70/format/webp"
            alt="sale"
        /> -->
    </div>
    <main class="align-center flex flex-col items-center">
        <AppFilters :currentFilter="currentFilter" @update:current-filter="setCurrentFilter"></AppFilters>
        <div class="mt-4 flex w-7xl flex-col">
            <AppProductsGrid>
                <AppProductsItem v-for="item in goods" :key="item.id" :item="{ ...item }"> </AppProductsItem>
            </AppProductsGrid>
            <Button class="cursor-poiner mt-8" @click="updateGoods">See more</Button>
        </div>
    </main>
    <AppFooter></AppFooter>
</template>
