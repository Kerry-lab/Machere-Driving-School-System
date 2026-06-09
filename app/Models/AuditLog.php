<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'created_at',
    ];

    // An audit log belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Static method to record any action
    public static function record($action, $modelType = null, $modelId = null, $oldValues = null, $newValues = null)
    {
        self::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'model_type' => $modelType,
            'model_id'   => $modelId,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }
}