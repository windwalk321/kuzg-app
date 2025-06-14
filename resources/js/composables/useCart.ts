import { router } from '@inertiajs/vue3';

export function useCart() {
    const refreshCartCount = () => {
        router.reload({
            only: ['cartItemCount'],
            preserveScroll: true,
            preserveState: true,
        });
    };

    return { refreshCartCount };
}
