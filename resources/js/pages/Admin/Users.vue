<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
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
    users: {
        data: User[];
        current_page: number;
        total: number;
        per_page: number;
    };
}

export interface User {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    role: string;
    created_at: string;
}

const props = defineProps<Props>();

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const columnVisibility = ref<VisibilityState>({});

const columns: ColumnDef<User>[] = [
    {
        accessorKey: 'id',
        header: 'ID',
        cell: ({ row }) => row.getValue('id'),
    },
    {
        accessorKey: 'first_name',
        header: 'First Name',
        cell: ({ row }) => h('div', { class: 'font-medium' }, row.getValue('first_name')),
    },
    {
        accessorKey: 'last_name',
        header: 'Last Name',
        cell: ({ row }) => h('div', { class: 'font-medium' }, row.getValue('last_name')),
    },
    {
        accessorKey: 'email',
        header: 'Email',
        cell: ({ row }) => h('div', row.getValue('email')),
    },
    {
        accessorKey: 'role',
        header: 'Role',
        cell: ({ row }) => {
            const role = row.getValue('role') as string;
            return h(
                'div',
                {
                    class: [
                        'inline-block rounded-full px-2 py-1 text-xs capitalize',
                        role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800',
                    ].join(' '),
                },
                role,
            );
        },
    },
    {
        accessorKey: 'created_at',
        header: 'Joined',
        cell: ({ row }) => {
            const date = new Date(row.getValue('created_at'));
            return h('div', { class: 'text-sm text-gray-500' }, date.toLocaleDateString());
        },
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            return h('div', { class: 'flex space-x-2' }, [
                h(
                    'button',
                    {
                        variant: 'destructive',
                        size: 'sm',
                        onClick: () => {
                            if (confirm('Are you sure you want to delete this user?')) {
                                router.delete(route('admin.users.destroy', row.getValue('id')), {
                                    preserveScroll: true,
                                    onSuccess: () => {
                                        // Optional: Show success notification
                                    },
                                    onError: () => {
                                        // Handle error
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
    data: props.users.data,
    columns,
    getCoreRowModel: getCoreRowModel(),
    onSortingChange: (updater) => {
        if (typeof updater === 'function') {
            sorting.value = updater(sorting.value);
        } else {
            sorting.value = updater;
        }
    },
    onColumnFiltersChange: (updater) => {
        if (typeof updater === 'function') {
            columnFilters.value = updater(columnFilters.value);
        } else {
            columnFilters.value = updater;
        }
    },
    onColumnVisibilityChange: (updater) => {
        if (typeof updater === 'function') {
            columnVisibility.value = updater(columnVisibility.value);
        } else {
            columnVisibility.value = updater;
        }
    },
    state: {
        sorting: sorting.value,
        columnFilters: columnFilters.value,
        columnVisibility: columnVisibility.value,
    },
});
</script>

<template>
    <Head title="Users" />

    <AdminLayout>
        <div class="p-6">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Users</h1>
            </div>

            <div class="w-full">
                <!-- <div class="flex items-center py-4">
                    <Input
                        placeholder="Filter users..."
                        class="max-w-sm"
                        :model-value="table.getColumn('email')?.getFilterValue() as string"
                        @update:model-value="(value) => table.getColumn('email')?.setFilterValue(value)"
                    />

                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="outline" class="ml-auto"> Columns </Button>
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
                                    <div v-if="header.isPlaceholder">
                                        {{ null }}
                                    </div>
                                    <div v-else>
                                        <FlexRender :render="header.column.columnDef.header" :props="header.getContext()" />
                                    </div>
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-if="table.getRowModel().rows?.length === 0">
                                <TableCell :colspan="columns.length" class="h-24 text-center"> No users found. </TableCell>
                            </TableRow>
                            <TableRow v-else v-for="row in table.getRowModel().rows" :key="row.id">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>

                <div class="flex items-center justify-end space-x-2 py-4">
                    <div class="text-muted-foreground text-sm">
                        Page {{ props.users.current_page }} of {{ Math.ceil(props.users.total / props.users.per_page) }}
                    </div>
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="props.users.current_page <= 1"
                        @click="router.get(route('admin.users.index', { page: props.users.current_page - 1 }))"
                    >
                        Previous
                    </Button>
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="props.users.current_page * props.users.per_page >= props.users.total"
                        @click="router.get(route('admin.users.index', { page: props.users.current_page + 1 }))"
                    >
                        Next
                    </Button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
