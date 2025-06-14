<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import * as z from 'zod';

const props = defineProps<{
    product?: {
        id?: number;
        name: string;
        description: string;
        price: number;
        stock: number;
        image_url?: string;
        category_id: number;
        is_special_offer: boolean;
        offer_expires_at?: string | null;
    };
    categories: {
        id: number;
        name: string;
    }[];
    loading?: boolean;
}>();

const emit = defineEmits(['submit']);

// File input ref
const previewImage = ref(props.product?.image_url || '');

const formSchema = toTypedSchema(
    z.object({
        name: z.string().min(2, 'Name must be at least 2 characters'),
        description: z.string().min(10, 'Description must be at least 10 characters'),
        price: z.number().min(0.01, 'Price must be greater than 0'),
        stock: z.number().min(0, 'Stock cannot be negative'),
        category_id: z.number().min(1, 'Category is required'),
        is_special_offer: z.boolean().default(false),
        offer_expires_at: z.string().nullable().optional(),
        image: z
            .instanceof(File)
            .refine((file) => file.size <= 2 * 1024 * 1024, 'Image must be less than 2MB')
            .refine((file) => ['image/jpeg', 'image/png', 'image/webp'].includes(file.type), 'Only JPEG, PNG, or WebP images are allowed'),
    }),
);

const form = useForm({
    validationSchema: formSchema,
    initialValues: {
        name: '',
        description: '',
        price: 0,
        stock: 0,
        category_id: undefined,
        is_special_offer: false,
        offer_expires_at: null,
        image: undefined,
    },
});

const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        form.setFieldValue('image', file);
        previewImage.value = URL.createObjectURL(file);
    }
};

const fileInput = ref<{ input?: HTMLInputElement }>();

const triggerFileInput = () => {
    if (fileInput.value?.input) {
        fileInput.value.input.click();
    } else {
        // Fallback
        const input = document.createElement('input');
        input.type = 'file';
        input.click();
        input.onchange = handleFileChange;
    }
};

const onSubmit = form.handleSubmit((values) => {
    // Create FormData for file upload
    const formData = new FormData();

    // Append all form values
    Object.entries(values).forEach(([key, value]) => {
        if (value !== undefined && value !== null) {
            // Convert boolean to string '1' or '0'
            if (typeof value === 'boolean') {
                formData.append(key, value ? '1' : '0');
            } else {
                formData.append(key, value instanceof File ? value : String(value));
            }
        }
    });

    // Convert numbers explicitly
    formData.set('price', String(values.price));
    formData.set('stock', String(values.stock));
    formData.set('category_id', String(values.category_id));

    emit('submit', formData);
});
</script>

<template>
    <form @submit="onSubmit" class="space-y-6">
        <FormField v-slot="{ componentField, errorMessage }" name="name">
            <FormItem>
                <FormLabel>Product Name</FormLabel>
                <FormControl>
                    <Input type="text" v-bind="componentField" />
                </FormControl>
                <FormMessage v-if="errorMessage">
                    <span class="text-red-500">{{ errorMessage }}</span>
                </FormMessage>
            </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="description">
            <FormItem>
                <FormLabel>Description</FormLabel>
                <FormControl>
                    <Textarea v-bind="componentField" class="min-h-[100px]" />
                </FormControl>
                <FormMessage />
            </FormItem>
        </FormField>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <FormField v-slot="{ componentField }" name="price">
                <FormItem>
                    <FormLabel>Price</FormLabel>
                    <FormControl>
                        <Input type="number" step="0.01" v-bind="componentField" />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <FormField v-slot="{ componentField }" name="stock">
                <FormItem>
                    <FormLabel>Stock Quantity</FormLabel>
                    <FormControl>
                        <Input type="number" v-bind="componentField" />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

            <FormField v-slot="{ componentField }" name="category_id">
                <FormItem>
                    <FormLabel>Category</FormLabel>
                    <Select v-bind="componentField">
                        <FormControl>
                            <SelectTrigger>
                                <SelectValue placeholder="Select a category" />
                            </SelectTrigger>
                        </FormControl>
                        <SelectContent>
                            <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <div class="space-y-4">
            <FormField v-slot="{ value, handleChange }" name="is_special_offer">
                <FormItem class="flex flex-row items-start space-y-0 space-x-3 p-4">
                    <FormControl>
                        <Checkbox :checked="value" @update:checked="handleChange" />
                    </FormControl>
                    <div class="space-y-1 leading-none">
                        <FormLabel>Special Offer</FormLabel>
                        <FormDescription> Check this box if this product is a special offer </FormDescription>
                    </div>
                </FormItem>
            </FormField>

            <FormField v-slot="{ componentField }" name="offer_expires_at" v-if="form.values.is_special_offer">
                <FormItem>
                    <FormLabel>Offer Expires At</FormLabel>
                    <FormControl>
                        <Input type="datetime-local" v-bind="componentField" />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <FormField name="image">
            <FormItem>
                <FormLabel>Product Image</FormLabel>
                <div class="flex items-center gap-4">
                    <div v-if="previewImage" class="relative">
                        <img :src="previewImage" class="h-20 w-20 rounded-md object-cover" />
                        <button
                            type="button"
                            @click="
                                previewImage = '';
                                form.setFieldValue('image', undefined);
                            "
                            class="absolute -top-2 -right-2 rounded-full bg-red-500 p-1 text-white"
                        >
                            <XMarkIcon class="h-3 w-3" />
                        </button>
                    </div>
                    <FormControl>
                        <Input ref="fileInput" type="file" class="hidden" accept="image/*" @change="handleFileChange" />
                    </FormControl>
                    <Button type="button" variant="outline" @click="triggerFileInput">
                        {{ previewImage ? 'Change Image' : 'Upload Image' }}
                    </Button>
                </div>
                <FormDescription> Upload a product image (JPEG, PNG, etc.) </FormDescription>
                <FormMessage />
            </FormItem>
        </FormField>

        <Button type="submit" :disabled="loading">
            <span v-if="loading" class="flex items-center">
                <svg class="mr-2 h-4 w-4 animate-spin" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    ></path>
                </svg>
                Processing...
            </span>
            <span v-else>{{ product?.id ? 'Update Product' : 'Create Product' }}</span>
        </Button>
    </form>
</template>
