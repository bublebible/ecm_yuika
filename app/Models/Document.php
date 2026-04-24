<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'type',
        'file_path',
        'status',
        'admin_note',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
