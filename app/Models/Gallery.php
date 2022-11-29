<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Gallery extends Model
{
	use LogsActivity;
	use SoftDeletes;

	const TABLE_NAME   = 'gallery';
	const ID           = 'id';
	const NAMA_RUANGAN = 'nama_ruangan';
	const TIPE         = 'tipe';
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

	public static $rules = [
		self::NAMA_RUANGAN => 'required|string',
		self::TIPE         => 'required|nullable|string',
		self::DESKRIPSI    => 'required|nullable|string',
		self::KAPASITAS    => 'required|integer',
		self::GAMBAR       => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
	];

	protected $table    = self::TABLE_NAME;
	protected $fillable = [
		self::NAMA_RUANGAN,
		self::TIPE,
		self::DESKRIPSI,
		self::KAPASITAS,
		self::GAMBAR,
		self::CREATED_BY,
		self::UPDATED_BY,
		self::DELETED_BY,
		self::IS_DELETED,
	];

	protected $casts = [
		self::CREATED_AT => 'datetime:Y-m-d H:i:s',
		self::UPDATED_AT => 'datetime:Y-m-d H:i:s',
		self::DELETED_AT => 'datetime:Y-m-d H:i:s',
	];

	protected static $logName = 'product';
	protected static $logFillable = true;

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

	public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }
}
