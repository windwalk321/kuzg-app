import type { PaginatedProducts, Product, ProductCreateRequest, ProductUpdateRequest } from '@/types/product';
import axios from 'axios';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export const getProducts = async (params?: {
    page?: number;
    per_page?: number;
    category?: string;
    special_offer?: boolean;
}): Promise<PaginatedProducts> => {
    const response = await axios.get(`${API_BASE_URL}/products`, { params });
    return response.data;
};

export const getProduct = async (id: number): Promise<{ data: Product }> => {
    const response = await axios.get(`${API_BASE_URL}/products/${id}`);
    return response.data;
};

export const createProduct = async (productData: ProductCreateRequest): Promise<Product> => {
    const formData = new FormData();
    Object.entries(productData).forEach(([key, value]) => {
        if (value !== null && value !== undefined) {
            formData.append(key, value instanceof File ? value : String(value));
        }
    });

    const response = await axios.post(`${API_BASE_URL}/products`, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    });
    return response.data.data;
};

export const updateProduct = async (productData: ProductUpdateRequest): Promise<Product> => {
    const formData = new FormData();
    Object.entries(productData).forEach(([key, value]) => {
        if (value !== null && value !== undefined && key !== 'id') {
            formData.append(key, value instanceof File ? value : String(value));
        }
    });

    const response = await axios.post(`${API_BASE_URL}/products/${productData.id}`, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    });
    return response.data.data;
};

export const deleteProduct = async (id: number): Promise<void> => {
    await axios.delete(`${API_BASE_URL}/products/${id}`);
};
