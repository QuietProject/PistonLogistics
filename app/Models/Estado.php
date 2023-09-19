<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Estado
 * 
 * @property int $ID_lote
 * @property Carbon $fecha
 * @property int|null $tipo
 * 
 * @property Lote $lote
 *
 * @package App\Models
 */
class Estado extends Model
{
	protected $table = 'estados';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_lote' => 'int',
		'fecha' => 'datetime',
		'tipo' => 'int'
	];

	protected $fillable = [
		'tipo'
	];

	public function lote()
	{
		return $this->belongsTo(Lote::class, 'ID_lote');
	}
}
