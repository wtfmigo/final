<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'client_name',
        'client_email',
        'client_address',
        'payment_conditions',
        'currency',
        'invoice_date',
        'due_date',
        'status',
        'subtotal',
        'tax',
        'total',
        'products',
        'additional_info',
    ];

    protected $casts = [
        'products'     => 'array',
        'invoice_date' => 'date',
        'due_date'     => 'date',
        'subtotal'     => 'decimal:2',
        'tax'          => 'decimal:2',
        'total'        => 'decimal:2',
    ];

    /**
     * Boot method to set defaults.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->status)) {
                $invoice->status = 'Pending';
            }
            if (empty($invoice->currency)) {
                $invoice->currency = 'PHP';
            }
        });
    }
}
