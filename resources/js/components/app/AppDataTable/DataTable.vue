<script setup lang="ts" generic="TData, TValue">
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { router } from '@inertiajs/vue3';
import { FlexRender, getCoreRowModel, useVueTable, type ColumnDef, type PaginationState } from '@tanstack/vue-table';
import { Loader2 } from 'lucide-vue-next';
import { h, ref } from 'vue';

export interface User {
    id: string;
    first_name: string;
    last_name: string;
    role: string;
    email: string;
    is_admin?: boolean;
}

const props = defineProps<{
    auth: {
        user: User;
    };
    data: object;
    pagination: {
        current_page: number;
        per_page: number;
        total: number;
        last_page: number;
    };
    loading?: boolean;
}>();

const columns: ColumnDef<User>[] = [
    {
        accessorKey: 'id',
        header: 'ID',
    },
    {
        accessorKey: 'first_name',
        header: 'First Name',
    },
    {
        accessorKey: 'last_name',
        header: 'Last Name',
    },
    {
        accessorKey: 'email',
        header: 'E-mail',
    },
    {
        accessorKey: 'role',
        header: 'Role',
    },
    {
        id: 'actions',
        header: 'Actions',
        cell: (info: any) => {
            const user = info.row.original;
            return user.role !== 'admin'
                ? h(
                      'button',
                      {
                          class: 'text-red-600 hover:text-red-900',
                          onClick: () => {
                              deleteUser(user.id);
                          },
                      },
                      'Delete',
                  )
                : '';
        },
    },
];

const emit = defineEmits<{
    (e: 'pageChange', page: number): void;
    (e: 'pageSizeChange', size: number): void;
}>();

const pagination = ref<PaginationState>({
    pageIndex: props.pagination.current_page - 1,
    pageSize: props.pagination.per_page,
});

const lastPage = ref(props.pagination.last_page);

const table = useVueTable({
    get data() {
        return props.data;
    },
    get columns() {
        return columns;
    },
    getCoreRowModel: getCoreRowModel(),
    manualPagination: true, // Important for server-side pagination
    pageCount: lastPage.value,
    onPaginationChange: (updater) => {
        const newPagination = typeof updater === 'function' ? updater(pagination.value) : updater;

        if (newPagination.pageIndex !== pagination.value.pageIndex) {
            emit('pageChange', newPagination.pageIndex + 1);
        }

        pagination.value = newPagination;
    },
    get state() {
        return {
            pagination: pagination.value,
        };
    },
});

const deleteUser = (userId: number) => {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(route('admin.users.destroy', userId), {
            preserveScroll: true,
            onSuccess: () => {
                // Optional: Show toast notification
            },
            onError: () => {
                // handling Errro
            },
        });
    }
};
</script>

<template>
    <div>
        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead v-for="header in headerGroup.headers" :key="header.id">
                            <div v-if="!header.isPlaceholder">
                                {{ header.column.columnDef.header }}
                            </div>
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <TableRow v-for="row in table.getRowModel().rows" :key="row.id" :data-state="row.getIsSelected() ? 'selected' : undefined">
                            <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                            </TableCell>
                        </TableRow>
                    </template>
                    <template v-else>
                        <TableRow>
                            <TableCell :colspan="columns.length" class="h-24 text-center"> No results. </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <div class="text-muted-foreground flex-1 text-sm">Showing {{ table.getRowModel().rows.length }} of {{ props.data.length }} results</div>
            <div class="flex items-center space-x-6 lg:space-x-8">
                <div class="flex w-[100px] items-center justify-center text-sm font-medium">
                    Page {{ table.getState().pagination.pageIndex + 1 }} of
                    {{ table.getPageCount() }}
                </div>
                <div class="flex items-center space-x-2">
                    <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage() || loading" @click="table.setPageIndex(0)">
                        <span v-if="!loading">First</span>
                        <Loader2 v-else class="h-4 w-4 animate-spin" />
                    </Button>
                    <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage() || loading" @click="table.previousPage()">
                        <span v-if="!loading">Previous</span>
                        <Loader2 v-else class="h-4 w-4 animate-spin" />
                    </Button>
                    <Button variant="outline" size="sm" :disabled="!table.getCanNextPage() || loading" @click="table.nextPage()">
                        <span v-if="!loading">Next</span>
                        <Loader2 v-else class="h-4 w-4 animate-spin" />
                    </Button>
                    <Button
                        variant="outline"
                        size="sm"
                        :disabled="!table.getCanNextPage() || loading"
                        @click="table.setPageIndex(table.getPageCount() - 1)"
                    >
                        <span v-if="!loading">Last</span>
                        <Loader2 v-else class="h-4 w-4 animate-spin" />
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
