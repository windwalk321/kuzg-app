<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image_url' => $this->image_url,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug
            ],
            'is_special_offer' => $this->is_special_offer,
            'offer_expires_at' => $this->offer_expires_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
