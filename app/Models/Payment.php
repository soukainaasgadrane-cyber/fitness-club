<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // 💚 Fields li katsift f create() / save()
    protected $fillable = [
        'member_id',
        'plan_id',
        'amount',
        'payment_date',
        'status',
    ];

    // Relation m3a Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Relation m3a Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}