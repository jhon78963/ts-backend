<?php

namespace App\Product\Models;

use App\Brand\Models\Brand;
use App\Category\Models\Category;
use App\Image\Models\Image;
use App\Measurement\Models\Measurement;
use App\Order\Models\Order;
use App\Product\Enums\ProductStatus;
use App\Sale\Models\Sale;
use App\Store\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'sale_price',
        'purchase_price',
        'stock',
        'image',
        'status',
        'category_id',
        'brand_id',
        'measurement_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'creator_user_id',
        'last_modification_time',
        'last_modifier_user_id',
        'is_deleted',
        'deleter_user_id',
        'deletion_time',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ProductStatus::class,
            'purchase_price' => 'float',
            'sale_price' => 'float',
        ];
    }

    /**
     * Scope a query to only include products with stock greater than 0.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Get the images associated with the product.
     *
     * @return BelongsToMany
     */
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(
            Image::class,
            'product_image',
            'product_id',
            'path',
            'id',
            'id',
        )->withPivot(['status']);
    }

    /**
     * Get the category associated with the product.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the measurement associated with the product.
     *
     * @return BelongsTo
     */
    public function measurement(): BelongsTo
    {
        return $this->belongsTo(Measurement::class);
    }

    /**
     * Get the brand associated with the product.
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the stores associated with the product.
     *
     * @return BelongsToMany
     */
    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(
            Store::class,
            'product_store',
            'product_id',
            'store_id',
            'id',
            'id',
        )->withPivot(['stock']);
    }

    /**
     * Get the orders associated with the product.
     *
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(
            Order::class,
            'order_product',
        )->withPivot(['quantity', 'price']);
    }

    /**
     * Get the sales associated with the product.
     *
     * @return BelongsToMany
     */
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(
            Sale::class,
            'product_sale',
        )->withPivot(['quantity', 'price']);
    }
}
