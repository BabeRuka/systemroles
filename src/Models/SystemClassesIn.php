<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemClassesIn extends Model
{
    protected $table = 'system_classes_in';
    protected $primaryKey = 'in_id';
    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'class_id',
        'in_role', 
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(SystemClassesIn::class, 'class_id', 'class_id');
    }
    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRoles::class, 'role_id', 'role_id');
    }
}