<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRolesIn extends Model
{
    protected $table = 'user_roles_in';
    protected $primaryKey = 'perm_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'in_id',
        'in_role',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(SystemRolesIn::class, 'in_id', 'in_id');
    }
}
