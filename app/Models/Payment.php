<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_procedure_id',
        'amount',
        'status',
        'payment_method',
        'transaction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => 'string',
    ];

    public function userProcedure()
    {
        return $this->belongsTo(UserProcedure::class);
    }
}
