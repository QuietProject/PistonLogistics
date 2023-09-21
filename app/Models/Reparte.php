<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reparte
 * 
 * @property int $ID_paquete
 * @property string|null $matricula
 * @property Carbon $fecha_carga
 * @property Carbon|null $fecha_descarga
 * 
 * @property Paquete $paquete
 * @property Camioneta|null $camioneta
 *
 * @package App\Models
 */
class Reparte extends Model
{
	protected $table = 'reparte';
	protected $primaryKey = 'ID_paquete';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_paquete' => 'int',
		'fecha_carga' => 'datetime',
		'fecha_descarga' => 'datetime'
	];

	protected $fillable = [
		'matricula',
		'fecha_carga',
		'fecha_descarga'
	];

	public function paquete()
	{
		return $this->belongsTo(Paquete::class, 'ID_paquete');
	}

	public function camioneta()
	{
		return $this->belongsTo(Camioneta::class, 'matricula');
	}
}
