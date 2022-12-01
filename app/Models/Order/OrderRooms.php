<?php

namespace App\Models\Order;

use App\Models\Rooms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Traits\LogsActivity;

class OrderRooms extends Model
{
    use LogsActivity;
    use SoftDeletes;

    /**
     * Defining table and the columns
     */
    const TABLE_NAME   = 'order_rooms';
    const ID           = 'id';
    const ID_ROOM      = 'id_room';
    const AWAL         = 'awal';
    const AKHIR        = 'akhir';
    const QR           = 'qr';
    const STATUS       = 'status';
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
        self::ID_ROOM      => 'required|exists:rooms,id',
        self::AWAL         => 'nullable|datetime',
        self::AKHIR        => 'nullable|datetime',
        self::QR           => 'nullable|string',
        self::STATUS       => 'required|in:0,1,2',
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
    protected $guarded = [
        self::ID
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
    public const PERMISSION_GROUP_NAME = 'order_rooms';

    /**
     * List permission Meeting Room
     */
    public const PERMISSION_APPROVE = 'approve';
    public const PERMISSION_REJECT = 'reject';

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
