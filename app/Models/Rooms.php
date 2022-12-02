<?php

namespace App\Models;

use App\Models\Master\Floor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Rooms extends Model
{
    use LogsActivity;
    use SoftDeletes;

    /**
     * Defining table and the columns
     */
    const TABLE_NAME   = 'rooms';
    const ID           = 'id';
    const NAMA_RUANGAN = 'nama_ruangan';
    const ID_LANTAI    = 'id_lantai';
    const DESKRIPSI    = 'deskripsi';
    const KAPASITAS    = 'kapasitas';
    const GAMBAR       = 'gambar';
    const CREATED_BY   = 'created_by';
    const UPDATED_BY   = 'updated_by';
    const DELETED_BY   = 'deleted_by';
    const CREATED_AT   = 'created_at';
    const UPDATED_AT   = 'updated_at';
    const DELETED_AT   = 'deleted_at';
    const IS_DELETED   = 'is_deleted';
    const FETCH_LIMIT  = 10;

    /**
     * Columns defined for allow insert / update
     *
     * @var array
     */
    public static $rules = [
        self::NAMA_RUANGAN => 'required|string',
        self::ID_LANTAI    => 'required|nullable|string',
        self::DESKRIPSI    => 'required|nullable|string',
        self::KAPASITAS    => 'required|integer',
        self::GAMBAR       => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
    ];

    /**
     * Table name
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * Rules validation for Meeting Room
     *
     * @var array
     */
    protected $fillable = [
        self::NAMA_RUANGAN,
        self::ID_LANTAI,
        self::DESKRIPSI,
        self::KAPASITAS,
        self::GAMBAR,
        self::CREATED_BY,
        self::UPDATED_BY,
        self::DELETED_BY,
        self::IS_DELETED,
    ];

    /**
     * Casts for date's columns
     *
     * @var array
     */
    protected $casts = [
        self::CREATED_AT => 'datetime:Y-m-d H:i:s',
        self::UPDATED_AT => 'datetime:Y-m-d H:i:s',
        self::DELETED_AT => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * All statuses for Order Rooms
     */
    const STATUS_DRAFT = 1;
    const STATUS_APPROVE = 2;
    const STATUS_REJECT = 3;

    /**
     * List Orders for Room
     */
    public const STATUS_ORDER = [
        self::STATUS_DRAFT,
        self::STATUS_APPROVE,
        self::STATUS_REJECT
    ];

    /**
     * Permission group name Meeting Room
     */
    public const PERMISSION_GROUP_NAME = 'rooms';

    /**
     * List permission Meeting Room
     */
    public const PERMISSION_CREATE = 'create';
    public const PERMISSION_VIEW = 'view';
    public const PERMISSION_EDIT = 'edit';
    public const PERMISSION_DELETE = 'delete';

    /**
     * Relation Meeting Room
     */
    public function lantai()
    {
        return $this->hasOne(Floor::class, 'id', 'id_lantai');
    }

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

    /**
     * Soft Delete method
     *
     * @return void
     */
    protected function runSoftDelete()
    {
        $query = $this->newQuery()->where($this->getKeyName(), $this->getKey());
        $time  = $this->freshTimestamp();
        $query->update([
            self::DELETED_BY => Auth::guard('admin')->user()->id,
            self::DELETED_AT => $this->fromDateTime($time),
            self::IS_DELETED => 1,
        ]);
    }
}
