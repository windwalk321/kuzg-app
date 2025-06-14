export interface Cart {
    id: number | null;
    user_id: number | null;
    items: CartItem[];
    total: number;
    created_at: string;
    updated_at: string;
}

export interface CartItem {
    id: string | number;
    product_id: number;
    quantity: number;
    product: Product;
    subtotal: number;
    created_at: string;
    updated_at: string;
}

export interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
    image_url: string;
    category_id: number;
    is_special_offer: boolean;
    offer_expires_at: string | null;
}
