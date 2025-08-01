<?php

namespace App\Product\Models;

use App\Brand\Models\Brand;
use App\Category\Models\Category;
use App\Measurement\Models\Measurement;
use App\Order\Models\Order;
use App\Product\Enums\ProductStatus;
use App\Product\Factories\ProductFactory;
use App\Sale\Models\Sale;
use App\Store\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Exception;
use InvalidArgumentException;

class Product extends Model
{
    use HasFactory;

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

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
     * Decrease the product stock.
     *
     * @param int $amount
     * @throws InvalidArgumentException if the amount is invalid
     * @throws Exception if the stock is insufficient
     */
    public function decreaseStock(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("La cantidad debe ser mayor a 0.");
        }

        if ($this->stock < $amount) {
            throw new Exception("No hay suficiente stock para el producto: {$this->name}.");
        }

        $this->stock -= $amount;
        $this->save();
    }

    /**
     * Increase the product stock.
     *
     * @param int $amount
     * @throws InvalidArgumentException if the amount is invalid
     */
    public function increaseStock(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("La cantidad debe ser mayor a 0.");
        }

        $this->stock += $amount;
        $this->save();
    }

    /**
     * Update the product status based on current stock.
     *
     * @return void
     */
    public function updateStatusBasedOnStock(): void
    {
        if ($this->stock === 0) {
            $this->status = 'OUT_OF_STOCK';
        } elseif ($this->stock <= 10) {
            $this->status = 'LIMITED_STOCK';
        } else {
            $this->status = 'AVAILABLE';
        }

        $this->save();
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
