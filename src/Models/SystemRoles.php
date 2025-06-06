<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemRoles extends Model
{
    protected $table = 'system_roles';
    protected $primaryKey = 'role_id';
    public $timestamps = true;

    protected $fillable = [
        'role_name',
        'role_guard_name',
        'role_description',
        'role_lang_name',
        'role_role_class',
        'role_sequence',
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(SystemRolesIn::class, 'role_id', 'role_id');
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRoles::class, 'user_role', 'role_id');
        
    }
}
