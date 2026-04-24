<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'version',
        'status',
        'notes',
        'image',
        'created_by_user_id',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
