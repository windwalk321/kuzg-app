<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import { Link } from '@inertiajs/vue3';
import { ShoppingCart, UserRound } from 'lucide-vue-next';
import { ref } from 'vue';

const shoppingBasketItems = ref([
    {
        id: 1,
        name: '4/8/12pcs Solar Powered Flickering Flame Garden Lights',
        price: 34.99,
        imageUrl: 'https://img.kwcdn.com/product/1f79702ba8/12bc837c-d451-4305-bf5e-d8d6e2268685_800x800.jpeg?imageView2/2/w/800/q/70/format/webp',
        rating: 5,
        dateStarted: '1 year ago',
    },
]);
</script>

<template>
    <header class="flex h-24 justify-center py-4">
        <div class="align-center flex w-7xl justify-between">
            <Link :href="route('home')"><h1 class="text-uppercase text-4xl font-bold">- Yarmarok -</h1></Link>

            <div class="flex items-center">
                <Link :href="route('profile')" class="align-center relative flex cursor-pointer items-center rounded-full p-3 hover:bg-[#19140035]">
                    <UserRound></UserRound>
                </Link>
                <Link :href="route('cart')" class="align-center relative flex cursor-pointer items-center rounded-full p-3 hover:bg-[#19140035]">
                    <div
                        v-if="shoppingBasketItems.length > 0"
                        class="absolute top-0 left-full flex -translate-x-1/2 transform overflow-hidden rounded-full"
                    >
                        <Badge variant="destructive">
                            {{ shoppingBasketItems.length }}
                        </Badge>
                    </div>
                    <ShoppingCart></ShoppingCart>
                </Link>

                <div class="ml-8">
                    <Link
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035]"
                        :href="route('login')"
                        >Login</Link
                    >
                    <Link
                        class="hover:border-[#1915014a ml-3 inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18]"
                        :href="route('register')"
                        >Register</Link
                    >
                </div>
            </div>
        </div>
    </header>
</template>
