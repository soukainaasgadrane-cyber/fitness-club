<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration_type',
        'duration_months',
        'price',
        'description',
        'features',
        'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }

    // دالة مساعدة للحصول على اسم المدة بالعربية
    public function getDurationTextAttribute()
    {
        return match($this->duration_type) {
            'monthly' => 'شهري',
            'quarterly' => 'ربع سنوي',
            'yearly' => 'سنوي',
            default => $this->duration_type
        };
    }
    // زيدي مع العلاقات الموجودة
public function plan()
{
    return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
}

// دالة لحساب المبلغ المتبقي
public function calculateRemainingAmount()
{
    return $this->price - $this->amount_paid;
}

// دالة للتحقق إذا كان مدفوع بالكامل
public function isFullyPaid()
{
    return $this->payment_status === 'paid';
}

// دالة للتحقق إذا كان الاشتراك ساري المفعول
public function isValid()
{
    return $this->is_active && $this->end_date >= now();
}
}