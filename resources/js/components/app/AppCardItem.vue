<script setup lang="ts">
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import { CalendarCheck, Star, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';
import Button from '../ui/button/Button.vue';

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    price: {
        type: Number,
        required: true,
    },
    imageUrl: {
        type: String,
        required: true,
    },
    rating: {
        type: Number,
        required: true,
    },
    dateStarted: {
        type: String,
        required: true,
    },
    amount: {
        type: Number,
        required: true,
    },
});

const amount = ref(props.amount);
// const amount = computed(() => props.amount);

const ratingArray = (length: number) => {
    return Array.from({ length }, (_, i) => i + 1);
};

const emit = defineEmits(['update:amount', 'remove']);
const handleAmountChange = (value: number) => {
    amount.value = value;
    emit('update:amount', value);
};
const handleRemove = () => {
    emit('remove', props.id);
};
</script>

<template>
    <div class="flex border-t border-gray-300 py-4 first:border-t-0">
        <div class="flex">
            <div class="flex h-24 w-24">
                <img :src="props.imageUrl" :alt="props.name" />
            </div>
            <div class="ml-4 flex flex-col">
                <h3 class="font-medium text-gray-600">{{ props.name }}</h3>
                <p class="mt-4 inline-block font-medium">{{ props.price }} $USD</p>
                <div class="mt-2 flex items-center font-medium">
                    <CalendarCheck color="green"></CalendarCheck>
                    <p class="ml-2 inline-block text-sm">{{ props.dateStarted }}</p>
                </div>
                <div class="mt-2 flex">
                    <Star color="gold" v-for="n in ratingArray(props.rating)" :key="n"></Star>
                    <span class="ml-1 font-medium text-gray-500">5</span>
                </div>
            </div>
        </div>
        <div class="ml-auto flex flex-col justify-between">
            <div>
                <NumberField id="age" :model-value="amount" @update:model-value="handleAmountChange" :min="0">
                    <NumberFieldContent>
                        <NumberFieldDecrement />
                        <NumberFieldInput />
                        <NumberFieldIncrement />
                    </NumberFieldContent>
                </NumberField>
            </div>
            <Button variant="secondary" size="icon" @click="handleRemove" class="ml-auto cursor-pointer">
                <Trash2></Trash2>
            </Button>
        </div>
    </div>
</template>
