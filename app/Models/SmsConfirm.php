<?php

namespace App\Models;

use App\Core\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsConfirm extends CoreModel
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'old_phone',
        'code',
        'try_count',
        'resend_count',
        'expired_at',
        'unblocked_at',
    ];

    protected $casts = [
        'expired_at'   => 'datetime',
        'unblocked_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'expired_at',
        'unblocked_at',
        'updated_at'];

    public function scopePhone($query, $phone)
    {
        return $query->wherePhone($phone);
    }
}
