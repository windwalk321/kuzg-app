<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Link } from '@inertiajs/vue3';
import { CalendarCheck, ShoppingBasket, Star } from 'lucide-vue-next';
defineProps<{
    item: {
        id: number;
        name: string;
        imageUrl: string;
        price: number;
        rating: number;
    };
}>();

const ratingArray = (length: number) => {
    return Array.from({ length }, (_, i) => i + 1);
};
</script>

<template>
    <div class="">
        <Link :href="route('product', { id: item.id })" class="block">
            <Card class="flex cursor-pointer border-none p-2 shadow-none hover:shadow-lg">
                <CardHeader class="p-0">
                    <div class="h-56 w-full">
                        <img :src="item.imageUrl" :alt="item.name" class="h-full w-full bg-[#191400] p-1 dark:bg-[#3E3E3A]" />
                    </div>
                    <CardTitle class="w-full truncate text-sm font-normal text-gray-500">{{ item.name }}</CardTitle>
                    <CardContent class="flex flex-col px-0">
                        <div class="flex justify-between">
                            <span class="font-bold">{{ item.price }} USD</span>
                            <Button variant="ghost" size="icon">
                                <ShoppingBasket></ShoppingBasket>
                            </Button>
                        </div>
                        <div class="flex">
                            <Star color="gold" v-for="n in ratingArray(item.rating)" :key="n"></Star>
                            <span class="ml-1 font-medium text-gray-500">5</span>
                        </div>
                    </CardContent>
                    <CardFooter class="flex px-0">
                        <CalendarCheck color="green"></CalendarCheck>
                        <span class="text-bold ml-1 text-sm font-bold">Started to sell on YARMAROK 1 year ago</span>
                    </CardFooter>
                </CardHeader>
            </Card>
        </Link>
    </div>
</template>
