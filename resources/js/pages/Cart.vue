<script setup lang="ts">
import AppCardItem from '@/components/app/AppCardItem.vue';
import AppFooter from '@/components/app/AppFooter.vue';
import AppHeader from '@/components/app/AppHeader.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Separator } from 'reka-ui';
import { ref } from 'vue';

const cartItems = ref([
    {
        id: 1,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
        amount: 1,
    },
    {
        id: 2,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
        amount: 1,
    },
    {
        id: 3,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
        amount: 1,
    },
    {
        id: 4,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
        amount: 1,
    },
    {
        id: 5,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
        amount: 1,
    },
    {
        id: 6,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
        amount: 1,
    },
    {
        id: 7,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
        amount: 1,
    },
    {
        id: 8,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
        amount: 1,
    },
]);

const updateAmount = (itemId: number, value: number) => {
    const index = cartItems.value.findIndex((item) => item.id === itemId);
    if (index !== -1) {
        cartItems.value[index].amount = value;
    }
};
</script>

<template>
    <Head title="Cart" />
    <AppHeader></AppHeader>
    <main class="flex w-full flex-col items-center">
        <div class="w-7xl">
            <h2 class="text-2xl font-bold">Shopping cart</h2>
            <Separator orientation="horizontal" class="my-4 h-px w-full bg-gray-300"></Separator>
            <div class="flex items-start">
                <div class="w-4xl">
                    <AppCardItem
                        v-for="item in cartItems"
                        :key="item.id"
                        :name="item.name"
                        :id="item.id"
                        :price="item.price"
                        :image-url="item.imageUrl"
                        :rating="item.rating"
                        :date-started="item.dateStarted"
                        :amount="item.amount"
                        @update:amount="updateAmount(item.id, $event)"
                    ></AppCardItem>
                </div>
                <div class="ml-auto flex w-xs flex-col rounded-lg bg-gray-100 p-8">
                    <h3 class="text-lg font-medium text-gray-600">Order summary</h3>
                    <div class="mt-8 flex flex-col">
                        <div class="mt-4 flex justify-between font-medium">
                            <p class="text-gray-400">Subtotal</p>
                            <p class="text-gray-600">$255.00</p>
                        </div>
                        <div class="mt-4 flex justify-between font-medium">
                            <p class="text-gray-400">Shipping estimate</p>
                            <p class="text-gray-600">$4.00</p>
                        </div>
                        <div class="mt-4 flex justify-between font-medium">
                            <p class="text-gray-400">Tax estimate</p>
                            <p class="text-gray-600">$3.50</p>
                        </div>
                    </div>
                    <Separator orientation="horizontal" class="my-4 h-px w-full bg-gray-300"></Separator>
                    <div class="flex justify-between font-medium">
                        <p class="text-gray-600">Total</p>
                        <p class="text-gray-600">$262.50</p>
                    </div>
                    <Link
                        :href="route('checkout')"
                        class="mt-8 flex cursor-pointer items-center justify-center rounded-md bg-black p-2 font-medium text-white hover:bg-gray-900"
                        >Checkout</Link
                    >
                </div>
            </div>
        </div>
    </main>
    <AppFooter></AppFooter>
</template>
