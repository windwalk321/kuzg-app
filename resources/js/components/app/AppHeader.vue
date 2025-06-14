<script setup lang="ts">
import CartIndicator from '@/components/app/AppCartIndicator.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Link, router, usePage } from '@inertiajs/vue3';
import { LogOut, Menu, User } from 'lucide-vue-next';
import { watchEffect } from 'vue';

interface Category {
    id: number;
    name: string;
    slug: string;
}

interface Props {
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
}

const props = defineProps<Props>();

const logout = () => {
    router.post(
        route('logout'),
        {},
        {
            onSuccess: () => {
                // Force reload to update cart count
                router.reload({ only: ['cartItemCount'] });
            },
        },
    );
};

watchEffect(() => {
    if (props.auth.user) {
        router.reload({ only: ['cartItemCount'] });
    }
});

const pageName = usePage().component;
const isCartPage = pageName === 'Cart';
</script>

<template>
    <header class="sticky top-0 z-50 border-b bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <!-- Top Bar -->
            <div class="flex items-center justify-between py-4">
                <!-- Mobile Menu Button (Hidden on desktop) -->
                <Button variant="ghost" size="icon" class="lg:hidden">
                    <Menu class="h-5 w-5" />
                </Button>

                <!-- Logo -->
                <Link href="/" class="flex items-center gap-2">
                    <span class="text-2xl font-bold text-rose-600">Yarmarok</span>
                </Link>

                <!-- Desktop Navigation (Hidden on mobile) -->
                <!-- <NavigationMenu class="hidden lg:block" v-if="!isCartPage">
                    <NavigationMenuList>
                        <NavigationMenuItem>
                            <NavigationMenuTrigger>Shop</NavigationMenuTrigger>
                            <NavigationMenuContent>
                                <div class="grid w-[400px] gap-3 p-4 md:w-[500px] md:grid-cols-2">
                                    <div v-for="category in categories" :key="category.id">
                                        <NavigationMenuLink as-child>
                                            <Link :href="`/?category=${category.slug}`" class="block rounded-md p-3 hover:bg-gray-100">
                                                <div class="text-sm leading-none font-medium">
                                                    {{ category.name }}
                                                </div>
                                            </Link>
                                        </NavigationMenuLink>
                                    </div>
                                </div>
                            </NavigationMenuContent>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child>
                                <Link href="/" class="px-4 py-2 text-sm font-medium"> About Us </Link>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child>
                                <Link href="/" class="px-4 py-2 text-sm font-medium"> Contact </Link>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                    </NavigationMenuList>
                </NavigationMenu> -->

                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-4">
                        <CartIndicator :item-count="cartItemCount" class="mr-3" v-if="!isCartPage" />

                        <!-- Authenticated User Dropdown -->
                        <DropdownMenu v-if="auth.user">
                            <DropdownMenuTrigger as-child>
                                <Button variant="ghost" class="relative h-8 w-8 cursor-pointer rounded-full">
                                    <Avatar class="h-8 w-8">
                                        <AvatarImage :src="auth.user.avatar || ''" />
                                        <AvatarFallback>
                                            <span class="sr-only">{{ auth.user.first_name.charAt(0).toUpperCase() }}</span>
                                        </AvatarFallback>
                                    </Avatar>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent class="w-56" align="end">
                                <div class="p-2">
                                    <div class="inline-block text-sm font-medium">
                                        <span>{{ auth.user.first_name }}</span>
                                        <span class="ml-2">{{ auth.user.last_name }}</span>
                                    </div>
                                    <p class="text-muted-foreground truncate text-xs">
                                        {{ auth.user.email }}
                                    </p>
                                </div>
                                <DropdownMenuItem as-child>
                                    <Link :href="route('profile')" class="w-full cursor-pointer">
                                        <User class="mr-2 h-4 w-4" />
                                        <span>Profile</span>
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem @click="logout" class="cursor-pointer">
                                    <LogOut class="mr-2 h-4 w-4" />
                                    <span>Log out</span>
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>

                        <!-- Guest Links -->
                        <template v-else>
                            <Button variant="outline" as-child>
                                <Link :href="route('login')">Log in</Link>
                            </Button>
                            <Button as-child>
                                <Link :href="route('register')">Register</Link>
                            </Button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
