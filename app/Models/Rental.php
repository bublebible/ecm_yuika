<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'start_date',
        'end_date',
        'total_price',
        'midtrans_order_id',
        'snap_token',
        'payment_status',
        'paid_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'paid_at'    => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(RentalItem::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }
}
