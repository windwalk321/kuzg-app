<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    class?: string;
}

const props = defineProps<Props>();
const className = computed(() => props.class);
</script>

<template>
    <div class="grid w-full grid-cols-5 gap-y-4" :class="className">
        <slot />
    </div>
</template>
