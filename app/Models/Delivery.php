<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'user_procedure_id',
        'delivery_type',
        'address',
        'file_path',
        'status',
        'tracking_code',
    ];

    protected $casts = [
        'delivery_type' => 'string',
        'status' => 'string',
    ];

    public function userProcedure()
    {
        return $this->belongsTo(UserProcedure::class);
    }
}
