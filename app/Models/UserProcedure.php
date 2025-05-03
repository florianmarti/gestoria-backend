<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProcedure extends Model
{
    protected $fillable = [
        'user_id',
        'procedure_id',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'status' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
}
