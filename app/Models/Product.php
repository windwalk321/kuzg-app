<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id',
        'is_special_offer',
        'offer_expires_at'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'offer_expires_at' => 'datetime',
        'is_special_offer' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        if (!$this->image || !Storage::disk('public')->exists($this->image)) {
            return asset('storage/products/placeholder.jpg');
        }
        
        return asset('storage/' . $this->image);
    }
}
