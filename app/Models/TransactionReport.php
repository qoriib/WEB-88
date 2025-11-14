<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'report_path',
        'emailed_to',
        'emailed_at',
        'generated_at',
        'meta',
    ];

    protected $casts = [
        'emailed_at' => 'datetime',
        'generated_at' => 'datetime',
        'meta' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
