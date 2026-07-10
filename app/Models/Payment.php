<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = [
        'consultation_id', 'invoice_number', 'amount', 'tax', 
        'total_amount', 'status', 'method', 'payment_date', 'proof'
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    // Auto generate invoice number
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payment) {
            $payment->invoice_number = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            // Hitung total dengan pajak 10%
            $payment->tax = $payment->amount * 0.1;
            $payment->total_amount = $payment->amount + $payment->tax;
        });
    }
}