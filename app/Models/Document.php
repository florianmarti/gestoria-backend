<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_procedure_id',
        'procedure_requirement_id',
        'file_path',
        'value',
        'status',
        'original_name',
        'thumbnail_path',
        'rejection_reason',
        'file_size',
        'mime_type'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function userProcedure()
    {
        return $this->belongsTo(UserProcedure::class);
    }

    public function requirement()
    {
        return $this->belongsTo(ProcedureRequirement::class, 'procedure_requirement_id');
    }
}
