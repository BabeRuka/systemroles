<?php

namespace BabeRuka\SystemRoles\Models;
use BabeRuka\SystemRoles\Traits\SystemClassesIn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
