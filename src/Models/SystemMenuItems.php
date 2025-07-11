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
class SystemMenuItems extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_menu_items';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'item_id';

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
        'item_name',
        'item_type',
        'item_icon'
    ];

    /** 
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'updated_at' => 'datetime', 
    ];

    public function menu()
    {
        return $this->belongsTo(SystemMenus::class, 'menu_id', 'menu_id');
    }
}
