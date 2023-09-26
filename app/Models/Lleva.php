<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lleva
 * 
 * @property int $ID_lote
 * @property string|null $matricula
 * @property Carbon $fecha_carga
 * @property Carbon|null $fecha_descarga
 * 
 * @property Lote $lote
 * @property Camion|null $camion
 *
 * @package App\Models
 */
class Lleva extends Model
{
	protected $table = 'lleva';
	protected $primaryKey = 'ID_lote';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_lote' => 'int',
		'fecha_carga' => 'datetime',
		'fecha_descarga' => 'datetime'
	];

	protected $fillable = [
		'matricula',
		'fecha_carga',
		'fecha_descarga'
	];

	public function lote()
	{
		return $this->belongsTo(Lote::class, 'ID_lote');
	}

	public function camion()
	{
		return $this->belongsTo(Camion::class, 'matricula');
	}
}
