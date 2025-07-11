<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemRoutes
 *
 * @package App\Models
 *
 * @property int $route_id
 * @property string $route_name
 * @property string $route_method
 * @property string|null $route_url
 * @property string|null $route_middleware
 * @property string|null $route_desc
 * @property string $route_action
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class SystemRoutes extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_routes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'route_id';

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
        'route_name',
        'route_method',
        'route_url',
        'route_middleware',
        'route_data',
        'route_desc',
        'route_action',
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
     * Get the system_menus_in entries associated with the route.
     */
    public function menusIn()
    {
        return $this->hasMany(SystemMenusIn::class, 'route_id', 'route_id');
    }

    /**
     * Get the system_routes_in entries associated with the route.
     */
    public function routesIn()
    {
        return $this->hasMany(SystemRoutessIn::class, 'route_id', 'route_id');
    }
}
