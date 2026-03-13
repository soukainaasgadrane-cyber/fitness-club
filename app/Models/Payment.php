<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_number',
        'subscription_id',
        'member_id',
        'user_id',
        'amount',
        'payment_method',
        'payment_type',
        'transaction_id',
        'check_number',
        'payment_date',
        'notes',
        'status',
        'receipt_path'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2'
    ];

    // العلاقات
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // دالة لإنشاء رقم فاتورة فريد
    public static function generatePaymentNumber()
    {
        $prefix = 'INV';
        $year = date('Y');
        $month = date('m');
        $lastPayment = self::whereYear('created_at', $year)
                          ->whereMonth('created_at', $month)
                          ->orderBy('id', 'desc')
                          ->first();

        if ($lastPayment) {
            $lastNumber = intval(substr($lastPayment->payment_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$prefix}-{$year}{$month}-{$newNumber}";
    }

    // دالة للحصول على طريقة الدفع بالعربية
    public function getPaymentMethodTextAttribute()
    {
        return match($this->payment_method) {
            'cash' => 'نقداً',
            'card' => 'بطاقة بنكية',
            'bank_transfer' => 'تحويل بنكي',
            'check' => 'شيك',
            default => $this->payment_method
        };
    }

}