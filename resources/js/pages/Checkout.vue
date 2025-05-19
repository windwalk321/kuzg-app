<script setup lang="ts">
import AppFooter from '@/components/app/AppFooter.vue';
import AppHeader from '@/components/app/AppHeader.vue';
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="checkout" />
    <AppHeader></AppHeader>
    <main class="flex flex-col items-center">
        <div class="flex w-7xl flex-col">
            <h2 class="text-2xl font-bold">Shipping details</h2>
            <Separator orientation="horizontal" class="my-4 h-px w-full bg-gray-300"></Separator>
            <div class="flex">
                <div class="flex w-3xl flex-col">
                    <form @submit.prevent="submit" class="mt-8 flex w-full flex-col gap-6">
                        <div class="flex">
                            <div class="flex-1">
                                <Label for="firstName">First Name</Label>
                                <Input class="mt-4" id="firstName" type="text" required autofocus :tabindex="1" placeholder="Ivan" />
                                <InputError :message="form.errors.email" />
                            </div>
                            <div class="ml-8 flex-1">
                                <Label for="lastName">Last Name</Label>
                                <Input class="mt-4" id="lastName" type="text" required autofocus :tabindex="1" placeholder="Kravchenko" />
                                <InputError :message="form.errors.email" />
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <Label for="lastName">Last Name</Label>
                            <Textarea placeholder="Main Str. 238" class="border-gray border-grey-500 mt-4 resize-none border p-4 shadow-sm" />
                        </div>
                        <div class="flex">
                            <div class="flex-1">
                                <Label for="city">City</Label>
                                <Input class="mt-4" id="city" type="text" required autofocus :tabindex="1" placeholder="New York" />
                                <InputError :message="form.errors.email" />
                            </div>
                            <div class="ml-8 flex-1">
                                <Label for="State">State</Label>
                                <Input class="mt-4" id="state" type="text" required autofocus :tabindex="1" placeholder="NY" />
                                <InputError :message="form.errors.email" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-1">
                                <Label for="city">Card number</Label>
                                <Input class="mt-4" id="city" type="text" required autofocus :tabindex="1" placeholder="1234 4321 1234 3214" />
                                <InputError :message="form.errors.email" />
                            </div>
                            <div class="ml-8 flex-1">
                                <Label for="State">CVV</Label>
                                <Input class="mt-4" id="state" type="text" required autofocus :tabindex="1" placeholder="123" />
                                <InputError :message="form.errors.email" />
                            </div>
                        </div>
                        <div class="flex">
                            <div class="flex-1">
                                <Label for="city">Zip</Label>
                                <Input id="city" class="mt-4" type="text" required autofocus :tabindex="1" placeholder="321245" />
                                <InputError :message="form.errors.email" />
                            </div>
                            <div class="ml-8 flex-1 self-end">
                                <Button class="flex w-full cursor-pointer">Place Order</Button>
                            </div>
                        </div>
                        <div class="text-muted-foreground self-start text-center text-sm">
                            <p>By placing your order, you agree to our Terms of Service and Privacy Policy .</p>
                        </div>
                    </form>
                </div>
                <div class="ml-auto flex w-xs flex-col self-start rounded-lg bg-gray-100 p-8">
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
                </div>
            </div>
        </div>
    </main>
    <AppFooter></AppFooter>
</template>
