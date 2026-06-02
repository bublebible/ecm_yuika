<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'category_id', // Replaces 'category' string
        'description',
        'price_per_day',
        'stock_qty',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function conditions()
    {
        return $this->hasMany(AssetCondition::class)->orderBy('version', 'desc');
    }

    public function latestCondition()
    {
        return $this->hasOne(AssetCondition::class)->orderBy('version', 'desc')->latest();
    }
}
