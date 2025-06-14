export interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
    image_url: string;
    is_special_offer?: boolean;
    offer_expires_at?: string;
    category: {
        id: number;
        name: string;
        slug: string;
    };
}

export interface ProductCreateRequest {
    name: string;
    description: string;
    price: number;
    stock: number;
    image: File | null;
    category_id: number;
    is_special_offer?: boolean;
    offer_expires_at?: string;
}

export interface ProductUpdateRequest extends Partial<ProductCreateRequest> {
    id: number;
}

export interface PaginatedProducts {
    data: Product[];
    meta: {
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
}
