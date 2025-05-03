<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureRequirement extends Model
{
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

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
