<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemMenus
 *
 * @package App\Models
 *
 * @property int $menu_id
 * @property string|null $menu_name
 * @property string|null $menu_desc
 * @property string|null $created_at // Note: SQL schema defines this as VARCHAR
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class SystemMenus extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_menus';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'menu_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'menu_name',
        'menu_desc',
        'menu_type'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'updated_at' => 'datetime', 
    ];

    /**
     * Get the system_menus_in entries associated with the menu.
     */
    public function menusIn()
    {
        return $this->hasMany(SystemMenussIn::class, 'menu_id', 'menu_id');
    }

    public function menusItem()
    {
        return $this->hasMany(SystemMenuItems::class, 'menu_id', 'menu_id');
    }
}
