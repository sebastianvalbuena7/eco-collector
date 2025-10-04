<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'collection_date',
        'collection_time',
        'waste_type',
        'estimated_weight',
        'actual_weight',
        'address',
        'status',
        'notes',
    ];

    protected $casts = [
        'collection_date' => 'date',
        'collection_time' => 'datetime:H:i',
        'estimated_weight' => 'decimal:2',
        'actual_weight' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->collection_date->format('d/m/Y') . ' ' . $this->collection_time->format('H:i');
    }
}
