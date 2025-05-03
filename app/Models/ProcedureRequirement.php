<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureRequirement extends Model
{
    use HasFactory;
    protected $fillable = [
        'procedure_id',
        'name',
        'type',
        'is_required',
        'description',
    ];

    protected $casts = [
        'type' => 'string',
        'is_required' => 'boolean',
    ];

    public function procedures()
    {
        return $this->belongsToMany(Procedure::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
