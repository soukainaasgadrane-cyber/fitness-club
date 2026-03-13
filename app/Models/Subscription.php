<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'plan_type',
        'price',
        'start_date',
        'end_date',
        'payment_status',
        'payment_method',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
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

    public function getStatusAttribute()
    {
        if ($this->end_date < now()) {
            return 'expired';
        }
        return $this->payment_status;
    }
    // زيدي مع العلاقات الموجودة
public function payments()
{
    return $this->hasMany(Payment::class);
}

// دالة لتسجيل دفعة جديدة
public function recordPayment($amount, $method, $userId, $notes = null)
{
    // إنشاء الدفعة
    $payment = Payment::create([
        'payment_number' => Payment::generatePaymentNumber(),
        'subscription_id' => $this->id,
        'member_id' => $this->member_id,
        'user_id' => $userId,
        'amount' => $amount,
        'payment_method' => $method,
        'payment_date' => now(),
        'notes' => $notes,
        'status' => 'completed'
    ]);

    // تحديث المبلغ المدفوع في الاشتراك
    $this->amount_paid += $amount;
    $this->remaining_amount = $this->price - $this->amount_paid;
    
    // تحديث حالة الدفع
    if ($this->remaining_amount <= 0) {
        $this->payment_status = 'paid';
    } elseif ($this->amount_paid > 0) {
        $this->payment_status = 'partial';
    }
    
    $this->save();

    return $payment;
}
}