<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $fillable = [
        'name',
        'category',
        'description',
        'fee',
        'estimated_days',
    ];

    protected $casts = [
        'category' => 'string',
        'fee' => 'decimal:2',
        'estimated_days' => 'integer',
    ];

    public function requirements()
    {
        return $this->hasMany(ProcedureRequirement::class);
    }

    public function userProcedures()
    {
        return $this->hasMany(UserProcedure::class);
    }
}
