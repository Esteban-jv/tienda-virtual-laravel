<?php

namespace App\Models;

use App\Models\Scopes\AvailableScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products'; // Solo para ProductTable y futuras herencias

    protected $with = [
        'images'
    ]; //(leccion 82)


    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'status'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AvailableScope);

        // Eventos (lección 104)
        // Se ejecuta después que el producto fué creado
        static::updated(function ($product) {
            if($product->stock == 0 AND $product->status != 'unavailable')
            {
                $product->status = 'unavailable';
                $product->save();
            }
        });
    }

    public function carts()
    {
        return $this->morphedByMany(Cart::class,'productable')->withPivot('quantity');
    }

    public function orders()
    {
        return $this->morphedByMany(Order::class,'productable')->withPivot('quantity');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function scopeAvailable($query)
    {
        $query->where('status','available');
    }

    public function getTotalAttribute()
    {
        return $this->pivot->quantity * $this->price;
    }
}
