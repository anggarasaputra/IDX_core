<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Floor extends Model
{
    use LogsActivity;
    use SoftDeletes;

    /**
     * Defining table and the columns
     */
    const TABLE_NAME   = 'master_lantai';
    const ID           = 'id';
    const NAME         = 'name';
    const ACTIVE       = 'active';
    const CREATED_BY   = 'created_by';
    const UPDATED_BY   = 'updated_by';
    const DELETED_BY   = 'deleted_by';
    const CREATED_AT   = 'created_at';
    const UPDATED_AT   = 'updated_at';
    const DELETED_AT   = 'deleted_at';
    const IS_DELETED   = 'is_deleted';

    /**
     * Define default maximum floor (lantai) inputs
     */
    public const MAX_FLOOR = 100;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * Rules validation for Master Lantai
     *
     * @var array
     */
    public static $rules = [
        /**
         * Alias for id is number in form input
         */
        'number'    => 'nullable|integer',
        self::ID    => 'nullable|integer',
        self::NAME  => 'required|string'
    ];

    /**
     * Columns defined for allow insert / update
     *
     * @var array
     */
    protected $fillable = [
        self::ID,
        self::NAME,
        self::CREATED_BY,
        self::UPDATED_BY,
        self::DELETED_BY,
        self::IS_DELETED,
    ];

    /**
     * Permission group name floor (lantai)
     */
    public const PERMISSION_GROUP_NAME = 'floor';

    /**
     * List permission floor (lantai)
     */
    public const PERMISSION_CREATE = 'create';
    public const PERMISSION_VIEW = 'view';
    public const PERMISSION_EDIT = 'edit';
    public const PERMISSION_DELETE = 'delete';

    /**
     * Model log name
     *
     * @var string
     */
    protected static $logName = 'product';

    /**
     * Model log fillable condition
     *
     * @var boolean
     */
    protected static $logFillable = true;

    /**
     * Get description for event log
     *
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }
}
