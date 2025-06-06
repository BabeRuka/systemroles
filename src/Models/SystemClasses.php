<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Model;

class SystemClasses extends Model
{
    protected $table = 'system_classes';
    protected $primaryKey = 'class_id';
    public $timestamps = true;

    protected $fillable = [
        'class_name',
        'class_filename',
        'class_description',
        'class_namespace',
        'role_role_class',
        'role_sequence',
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(SystemClassesIn::class, 'class_id', 'class_id');
    }

}
