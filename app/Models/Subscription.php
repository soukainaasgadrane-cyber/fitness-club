<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'plan_id',
        'plan_type',
        'price',
        'discount',
        'total_amount',
        'start_date',
        'end_date',
        'payment_due_date',
        'payment_date',
        'payment_status',
        'payment_method',
        'invoice_number',
        'payment_receipt',
        'transaction_id',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'payment_due_date' => 'date',
        'payment_date' => 'date',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function histories()
    {
        return $this->hasMany(SubscriptionHistory::class);
    }

    public function getStatusAttribute()
    {
        if ($this->end_date < now()) {
            return 'expired';
        }

        if ($this->payment_status === 'paid') {
            return 'active';
        }

        if ($this->payment_due_date && $this->payment_due_date < now()) {
            return 'overdue';
        }

        return 'pending';
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->end_date < now()) {
            return 0;
        }

        return now()->diffInDays($this->end_date);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('end_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now());
    }

    public function scopeOverdue($query)
    {
        return $query->where('payment_status', '!=', 'paid')
                     ->where('payment_due_date', '<', now());
    }
}