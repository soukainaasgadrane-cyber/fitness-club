<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'member_id',
        'plan_id',
        'subscription_id',
        'invoice_number',
        'amount',
        'discount_applied',
        'tax',
        'total_paid',
        'payment_method',
        'transaction_id',
        'payment_date',
        'status',
        'notes',
        'receipt_path'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount_applied' => 'decimal:2',
        'tax' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function getPaymentMethodNameAttribute()
    {
        $methods = [
            'cash' => 'Espèces',
            'card' => 'Carte bancaire',
            'bank_transfer' => 'Virement bancaire',
            'check' => 'Chèque'
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    public function getStatusNameAttribute()
    {
        $statuses = [
            'pending' => 'En attente',
            'completed' => 'Payé',
            'failed' => 'Échoué',
            'refunded' => 'Remboursé'
        ];

        return $statuses[$this->status] ?? $this->status;
    }
}