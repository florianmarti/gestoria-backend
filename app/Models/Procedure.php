<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "category",
        "description",
        "fee",
        "estimated_days",
    ];

    protected $casts = [
        "category" => "string",
        "fee" => "decimal:2",
        "estimated_days" => "integer",
    ];

    public function requirements()
    {
        return $this->belongsToMany(ProcedureRequirement::class, "procedure_procedure_requirement");
    }

    public function userProcedures()
    {
        return $this->hasMany(UserProcedure::class);
    }
}
