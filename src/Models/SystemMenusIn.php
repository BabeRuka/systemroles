<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemMenusIn
 *
 * @package App\Models
 *
 * @property int $in_id
 * @property int $menu_id
 * @property int $route_id
 * @property string $in_menu // Enum '0','1','2'
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class SystemMenusIn extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_menus_in';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'in_id';

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
        'menu_id',
        'route_id',
        'role_id',
        'in_role',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the menu that owns the SystemMenusIn entry.
     */
    public function systemMenu()
    {
        return $this->belongsTo(SystemMenu::class, 'menu_id', 'menu_id');
    }

    /**
     * Get the route that owns the SystemMenusIn entry.
     */
    public function systemRoute()
    {
        return $this->belongsTo(SystemRoute::class, 'route_id', 'route_id');
    }
}
