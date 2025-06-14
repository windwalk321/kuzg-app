<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';

defineProps<{
    itemCount: number;
}>();
</script>

<template>
    <Link :href="route('cart.index')">
        <Button variant="ghost" size="icon" class="relative cursor-pointer">
            <ShoppingCart class="h-5 w-5" />
            <Badge v-if="itemCount > 0" variant="destructive" class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center p-0">
                {{ itemCount }}
            </Badge>
        </Button>
    </Link>
</template>
