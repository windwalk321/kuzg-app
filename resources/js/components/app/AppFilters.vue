<script setup lang="ts">
import { computed, ref } from 'vue';

const props = defineProps<{
    currentFilter?: string;
}>();

const emit = defineEmits<{
    (e: 'update:currentFilter', value: string): void;
}>();

const items = ref([
    { id: 1, name: 'Recomended', key: 'recomended' },
    { id: 2, name: 'New goods', key: 'new' },
    { id: 3, name: 'Lowest Prices', key: 'lowest' },
    { id: 4, name: 'Best Sellers', key: 'best' },
    { id: 5, name: 'Most Popular', key: 'popular' },
]);

const currentItemId = computed<number>(() => {
    const currentItem = items.value.find((item) => item.key === props.currentFilter);
    return currentItem ? currentItem.id : items.value[0].id;
});

const setCurrentItemId = (id: number) => {
    const selectedItem = items.value.find((item) => item.id === id);
    if (selectedItem) emit('update:currentFilter', selectedItem.key);
};
</script>

<template>
    <div class="mt-8 flex w-7xl flex-col items-center">
        <h2 class="text-3xl font-bold">Explore your interests</h2>
        <Separator orientation="horizontal" class="my-4 h-px w-full bg-gray-300"></Separator>
        <div class="flex w-full pt-4">
            <div
                @click="setCurrentItemId(item.id)"
                v-for="item in items"
                :key="item.id"
                class="ml-3 cursor-pointer rounded-full border-1 px-6 py-3 first:ml-0 hover:shadow-sm"
                :class="item.id === currentItemId ? 'border-gray-500' : ''"
            >
                {{ item.name }}
            </div>
        </div>
    </div>
</template>
