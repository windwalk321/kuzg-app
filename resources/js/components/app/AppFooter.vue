<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="bg-background border-t py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center justify-between md:flex-row">
                <p class="text-muted-foreground mb-4 text-sm md:mb-0">&copy; {{ new Date().getFullYear() }} Yarmarok. All rights reserved.</p>
                <div class="flex space-x-6">
                    <Button variant="link" size="sm" as-child>
                        <Link href="/">Terms</Link>
                    </Button>
                    <Button variant="link" size="sm" as-child>
                        <Link href="/">Privacy</Link>
                    </Button>
                    <Button variant="link" size="sm" as-child>
                        <Link href="/">Contact</Link>
                    </Button>
                </div>
            </div>
        </div>
    </footer>
</template>
