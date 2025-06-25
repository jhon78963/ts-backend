<?php

namespace App\Sale\Models;

use App\Customer\Models\Customer;
use App\Product\Models\Product;
use App\Sale\Enums\SaleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'date',
        'status',
        'customer_id',
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
     * Get the calculated total for the order.
     *
     * This accessor sums the quantity multiplied by the price
     * of each product in the order's pivot table.
     *
     * @return float
     */
    public function getTotalAttribute(): float
    {
        return $this->products->sum(
            fn($product): float|int => $product->pivot->quantity * $product->pivot->price,
        );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => SaleStatus::class,
            'quantity' => 'int',
            'price' => 'float',
        ];
    }

    /**
     * Get the products associated with the sale.
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_sale',
        )->withPivot(['quantity', 'price']);
    }

    /**
     * Get the customer associated with the order.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
