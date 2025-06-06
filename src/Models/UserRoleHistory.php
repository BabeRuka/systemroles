<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoleHistory extends Model
{
    protected $table = 'user_roles_history';
    protected $primaryKey = 'history_id';
    public $incrementing = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**
     * Get the notes for the users.
     */
    public function user_role()
    {
        return $this->hasMany('App\Models\UserRole');
    }
    public function user()
    {
        return $this->hasMany('App\Models\Users');
    }
}
