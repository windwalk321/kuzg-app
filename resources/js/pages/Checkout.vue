<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import AppMainLayout from '@/layouts/AppMainLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ChevronLeft, CreditCard, Landmark, Wallet } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    cart: {
        items: Array<{
            id: string;
            product_id: number;
            quantity: number;
            product: {
                id: number;
                name: string;
                price: number;
                image_url: string;
            };
            subtotal: number;
        }>;
        total: number;
    };
    categories: Array<{
        id: number;
        name: string;
        slug: string;
    }>;
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

const paymentMethod = ref('credit_card');
const sameAsBilling = ref(true);

const form = ref({
    billing_address: {
        first_name: props.auth.user?.first_name || '',
        last_name: props.auth.user?.last_name || '',
        email: props.auth.user?.email || '',
        phone: '',
        address: '',
        city: '',
        state: '',
        zip_code: '',
        country: '',
    },
    shipping_address: {
        first_name: props.auth.user?.first_name || '',
        last_name: props.auth.user?.last_name || '',
        email: props.auth.user?.email || '',
        phone: '',
        address: '',
        city: '',
        state: '',
        zip_code: '',
        country: '',
    },
    payment_method: 'credit_card',
    notes: '',
});

const submitOrder = () => {
    if (sameAsBilling.value) {
        copyBillingToShipping();
    }
    router.post(route('checkout.store'), {
        ...form.value,
        payment_method: paymentMethod.value,
    });
};

const copyBillingToShipping = () => {
    form.value.shipping_address = { ...form.value.billing_address };
};
</script>

<template>
    <Head title="Checkout" />

    <AppMainLayout :categories="categories" :auth="auth" :cartItemCount="cartItemCount">
        <div class="container mx-auto px-4 py-8">
            <!-- Back button -->
            <Button variant="ghost" as-child class="mb-6">
                <Link :href="route('cart.index')" class="flex items-center gap-2">
                    <ChevronLeft class="h-4 w-4" />
                    Back to Cart
                </Link>
            </Button>

            <h1 class="mb-6 text-3xl font-bold tracking-tight text-gray-900">Checkout</h1>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Left column - Shipping and Payment -->
                <div class="space-y-8">
                    <!-- Shipping Address -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-xl">Shipping Address</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <Label for="shipping_first_name">First Name</Label>
                                    <Input id="shipping_first_name" v-model="form.shipping_address.first_name" required />
                                </div>
                                <div>
                                    <Label for="shipping_last_name">Last Name</Label>
                                    <Input id="shipping_last_name" v-model="form.shipping_address.last_name" required />
                                </div>
                            </div>

                            <div>
                                <Label for="shipping_email">Email</Label>
                                <Input id="shipping_email" type="email" v-model="form.shipping_address.email" required />
                            </div>

                            <div>
                                <Label for="shipping_phone">Phone</Label>
                                <Input id="shipping_phone" v-model="form.shipping_address.phone" required />
                            </div>

                            <div>
                                <Label for="shipping_address">Address</Label>
                                <Input id="shipping_address" v-model="form.shipping_address.address" required />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <Label for="shipping_city">City</Label>
                                    <Input id="shipping_city" v-model="form.shipping_address.city" required />
                                </div>
                                <div>
                                    <Label for="shipping_state">State/Province</Label>
                                    <Input id="shipping_state" v-model="form.shipping_address.state" required />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <Label for="shipping_zip_code">ZIP/Postal Code</Label>
                                    <Input id="shipping_zip_code" v-model="form.shipping_address.zip_code" required />
                                </div>
                                <div>
                                    <Label for="shipping_country">Country</Label>
                                    <Input id="shipping_country" v-model="form.shipping_address.country" required />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Billing Address -->
                    <Card>
                        <CardHeader>
                            <div class="flex items-center justify-between">
                                <CardTitle class="text-xl">Billing Address</CardTitle>
                                <div class="flex items-center space-x-2">
                                    <input
                                        id="same_as_shipping"
                                        type="checkbox"
                                        v-model="sameAsBilling"
                                        class="text-primary focus:ring-primary h-4 w-4 rounded border-gray-300"
                                    />
                                    <Label for="same_as_shipping">Same as shipping address</Label>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent class="space-y-4" :class="{ 'opacity-50': sameAsBilling }">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <Label for="billing_first_name">First Name</Label>
                                    <Input id="billing_first_name" v-model="form.billing_address.first_name" :disabled="sameAsBilling" required />
                                </div>
                                <div>
                                    <Label for="billing_last_name">Last Name</Label>
                                    <Input id="billing_last_name" v-model="form.billing_address.last_name" :disabled="sameAsBilling" required />
                                </div>
                            </div>

                            <div>
                                <Label for="billing_email">Email</Label>
                                <Input id="billing_email" type="email" v-model="form.billing_address.email" :disabled="sameAsBilling" required />
                            </div>

                            <div>
                                <Label for="billing_phone">Phone</Label>
                                <Input id="billing_phone" v-model="form.billing_address.phone" :disabled="sameAsBilling" required />
                            </div>

                            <div>
                                <Label for="billing_address">Address</Label>
                                <Input id="billing_address" v-model="form.billing_address.address" :disabled="sameAsBilling" required />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <Label for="billing_city">City</Label>
                                    <Input id="billing_city" v-model="form.billing_address.city" :disabled="sameAsBilling" required />
                                </div>
                                <div>
                                    <Label for="billing_state">State/Province</Label>
                                    <Input id="billing_state" v-model="form.billing_address.state" :disabled="sameAsBilling" required />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <Label for="billing_zip_code">ZIP/Postal Code</Label>
                                    <Input id="billing_zip_code" v-model="form.billing_address.zip_code" :disabled="sameAsBilling" required />
                                </div>
                                <div>
                                    <Label for="billing_country">Country</Label>
                                    <Input id="billing_country" v-model="form.billing_address.country" :disabled="sameAsBilling" required />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Payment Method -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-xl">Payment Method</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <RadioGroup v-model="paymentMethod" class="grid gap-4">
                                <div class="flex items-center space-x-3">
                                    <RadioGroupItem id="credit_card" value="credit_card" />
                                    <Label for="credit_card" class="flex items-center gap-2">
                                        <CreditCard class="h-5 w-5" />
                                        Credit Card
                                    </Label>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <RadioGroupItem id="paypal" value="paypal" />
                                    <Label for="paypal" class="flex items-center gap-2">
                                        <Landmark class="h-5 w-5" />
                                        PayPal
                                    </Label>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <RadioGroupItem id="bank_transfer" value="bank_transfer" />
                                    <Label for="bank_transfer" class="flex items-center gap-2">
                                        <Landmark class="h-5 w-5" />
                                        Bank Transfer
                                    </Label>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <RadioGroupItem id="cash_on_delivery" value="cash_on_delivery" />
                                    <Label for="cash_on_delivery" class="flex items-center gap-2">
                                        <Wallet class="h-5 w-5" />
                                        Cash on Delivery
                                    </Label>
                                </div>
                            </RadioGroup>
                        </CardContent>
                    </Card>

                    <!-- Order Notes -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-xl">Order Notes</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-2">
                                <Label for="notes">Special instructions</Label>
                                <Input id="notes" v-model="form.notes" placeholder="Notes about your order..." />
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right column - Order Summary -->
                <div class="space-y-6">
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-xl">Order Summary</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div v-for="item in cart.items" :key="item.id" class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <img :src="item.product.image_url" :alt="item.product.name" class="h-16 w-16 rounded-md border object-cover" />
                                    <div>
                                        <p class="font-medium">{{ item.product.name }}</p>
                                        <p class="text-sm text-gray-500">Qty: {{ item.quantity }}</p>
                                    </div>
                                </div>
                                <p class="font-medium">${{ item.subtotal.toFixed(2) }}</p>
                            </div>

                            <div class="space-y-2 border-t pt-4">
                                <div class="flex justify-between">
                                    <span>Subtotal</span>
                                    <span>${{ cart.total.toFixed(2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Shipping</span>
                                    <span class="text-green-600">FREE</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Tax</span>
                                    <span>$0.00</span>
                                </div>
                                <div class="flex justify-between border-t pt-2 text-lg font-bold">
                                    <span>Total</span>
                                    <span>${{ cart.total.toFixed(2) }}</span>
                                </div>
                            </div>
                        </CardContent>
                        <CardFooter>
                            <Button class="w-full" size="lg" @click="submitOrder" :disabled="cart.items.length === 0"> Place Order </Button>
                        </CardFooter>
                    </Card>
                </div>
            </div>
        </div>
    </AppMainLayout>
</template>
