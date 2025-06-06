<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRoles extends Model
{
    protected $table = 'user_roles';
    protected $primaryKey = 'role_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'user_role',
        'role_admin',
        'role_type',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(SystemRoles::class, 'user_role', 'role_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

