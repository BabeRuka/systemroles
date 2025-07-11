<?php

namespace BabeRuka\SystemRoles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemRoutesIn
 *
 * @package App\Models
 *
 * @property int $in_id
 * @property int $role_id
 * @property int $route_id
 * @property string $in_route // Enum '0','1','2'
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class SystemRoutesIn extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_routes_in';

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
        'role_id',
        'route_id',
        'in_route',
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
     * Get the route that owns the SystemRoutesIn entry.
     */
    public function systemRoute()
    {
        return $this->belongsTo(SystemRoute::class, 'route_id', 'route_id');
    }

    /**
     * Get the role that owns the SystemRoutesIn entry.
     *
     * Note: This assumes a `SystemRole` model exists.
     */
    public function systemRole()
    {
        return $this->belongsTo(SystemRole::class, 'role_id', 'role_id');
    }
}
