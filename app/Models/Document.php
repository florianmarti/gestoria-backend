<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        "user_procedure_id",
        "procedure_requirement_id",
        "file_path",
        "thumbnail_path",
        "value",
        "status",
        "rejection_reason",
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
