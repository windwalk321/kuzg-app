<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    FlexRender,
    getCoreRowModel,
    useVueTable,
    type ColumnDef,
    type ColumnFiltersState,
    type SortingState,
    type VisibilityState,
} from '@tanstack/vue-table';
import { h, ref } from 'vue';

interface Props {
    products: {
        data: Product[];
        current_page: number;
        total: number;
        per_page: number;
    };
    filters: {
        search: string;
    };
    categories: {
        id: number;
        name: string;
    }[];
}

export interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
    image: string;
    category_id: number;
    is_special_offer: boolean;
    offer_expires_at: string | null;
    category: {
        name: string;
    };
}

const props = defineProps<Props>();

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const columnVisibility = ref<VisibilityState>({});

const columns: ColumnDef<Product>[] = [
    {
        accessorKey: 'id',
        header: 'ID',
        cell: ({ row }) => row.getValue('id'),
    },
    {
        accessorKey: 'image_url',
        header: 'Image',
        cell: ({ row }) => {
            return h('img', {
                src: `/storage/${row.original.image}`,
                class: 'h-10 w-10 rounded object-cover',
                alt: row.original.name,
            });
        },
    },
    {
        accessorKey: 'name',
        header: 'Name',
        cell: ({ row }) => h('div', { class: 'font-medium' }, row.getValue('name')),
    },
    {
        accessorKey: 'category.name',
        header: 'Category',
        cell: ({ row }) => h('div', row.original.category?.name || '-'),
    },
    {
        accessorKey: 'price',
        header: 'Price',
        cell: ({ row }) => {
            const amount = parseFloat(row.getValue('price'));
            return h('div', { class: 'text-right' }, `$${amount.toFixed(2)}`);
        },
    },
    {
        accessorKey: 'stock',
        header: 'Stock',
        cell: ({ row }) => {
            const stock = parseInt(row.getValue('stock'));
            return h(
                'div',
                {
                    class: [
                        'inline-block rounded-full px-2 py-1 text-xs',
                        stock > 10 ? 'bg-green-100 text-green-800' : stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800',
                    ].join(' '),
                },
                `${stock} in stock`,
            );
        },
    },
    {
        accessorKey: 'is_special_offer',
        header: 'Special Offer',
        cell: ({ row }) => {
            const isSpecial = row.getValue('is_special_offer');
            return h(
                'div',
                {
                    class: [
                        'inline-block rounded-full px-2 py-1 text-xs',
                        isSpecial ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800',
                    ].join(' '),
                },
                isSpecial ? 'Yes' : 'No',
            );
        },
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            return h('div', { class: 'flex space-x-2' }, [
                h(
                    Button,
                    {
                        variant: 'outline',
                        size: 'sm',
                        onClick: () => router.get(route('admin.products.edit', row.original.id)),
                    },
                    'Edit',
                ),
                h(
                    Button,
                    {
                        variant: 'destructive',
                        size: 'sm',
                        onClick: () => {
                            if (confirm('Are you sure you want to delete this product?')) {
                                router.delete(route('admin.products.destroy', row.original.id), {
                                    preserveScroll: true,
                                    onSuccess: () => {
                                        // Show toast notification if needed
                                    },
                                });
                            }
                        },
                    },
                    'Delete',
                ),
            ]);
        },
    },
];

const table = useVueTable({
    data: props.products.data,
    columns,
    getCoreRowModel: getCoreRowModel(),
    state: {
        sorting: sorting.value,
        columnFilters: columnFilters.value,
        columnVisibility: columnVisibility.value,
    },
});
</script>

<template>
    <Head title="Products" />

    <AdminLayout>
        <div class="p-6">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Products</h1>
                <Button asChild>
                    <Link :href="route('admin.products.create')">Add Product</Link>
                </Button>
            </div>

            <div class="w-full">
                <!-- <div class="flex items-center py-4">
                    <Input
                        :value="table.getColumn('name')?.getFilterValue() ?? ''"
                        @input="table.getColumn('name')?.setFilterValue($event.target.value)"
                        placeholder="Filter products..."
                        class="max-w-sm"
                    />

                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="outline" class="ml-auto">Columns</Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                            <DropdownMenuCheckboxItem
                                v-for="column in table.getAllColumns().filter((c) => c.id !== 'actions')"
                                :key="column.id"
                                class="capitalize"
                                :checked="column.getIsVisible()"
                                @update:checked="(value) => column.toggleVisibility(!!value)"
                            >
                                {{ column.id }}
                            </DropdownMenuCheckboxItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div> -->

                <div class="rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                                <TableHead v-for="header in headerGroup.headers" :key="header.id">
                                    <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-if="table.getRowModel().rows?.length === 0">
                                <TableCell :colspan="columns.length" class="h-24 text-center"> No products found. </TableCell>
                            </TableRow>
                            <TableRow v-else v-for="row in table.getRowModel().rows" :key="row.id" :data-state="row.getIsSelected() && 'selected'">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>

                <div class="flex items-center justify-end space-x-2 py-4">
                    <div class="text-muted-foreground text-sm">
                        Page {{ products.current_page }} of {{ Math.ceil(products.total / products.per_page) }}
                    </div>
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="products.current_page <= 1"
                        @click="router.get(route('admin.products.index', { page: products.current_page - 1 }))"
                    >
                        Previous
                    </Button>
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="products.current_page * products.per_page >= products.total"
                        @click="router.get(route('admin.products.index', { page: products.current_page + 1 }))"
                    >
                        Next
                    </Button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
