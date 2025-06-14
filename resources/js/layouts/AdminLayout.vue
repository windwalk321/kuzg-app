<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';

const { auth } = usePage().props;
// const isAdmin = auth.user?.role === 'admin';
</script>

<template>
    <div>
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="font-bold text-white">Admin Panel</span>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <Link
                                    href="/admin/users"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                                    :class="{ 'bg-gray-900 text-white': $page.url.startsWith('/admin/users') }"
                                >
                                    Users
                                </Link>
                                <Link
                                    href="/admin/products"
                                    class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                                    :class="{ 'bg-gray-900 text-white': $page.url.startsWith('/admin/products') }"
                                >
                                    Products
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <!-- Profile dropdown -->
                            <div class="relative ml-3">
                                <div class="flex items-center text-white">
                                    <span class="mr-2">{{ auth.user?.name }}</span>
                                    <span class="rounded-full bg-blue-500 px-2 py-1 text-xs">{{ auth.user?.role }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <slot />
        </main>
    </div>
</template>
