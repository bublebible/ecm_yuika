<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'asset_id',
        'qty',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
