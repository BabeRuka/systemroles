<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemRolesIn extends Model
{
    protected $table = 'system_roles_in';
    protected $primaryKey = 'in_id';
    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'in_name',
        'in_guard_name',
        'in_role',
        'in_sequence',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(SystemRoles::class, 'role_id', 'role_id');
    }

    public function userPermissions(): HasMany
    {
        return $this->hasMany(UserRolesIn::class, 'in_id', 'in_id');
    }
}
