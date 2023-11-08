<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Trae
 *
 * @property int $ID_paquete
 * @property string $matricula
 * @property Carbon $fecha_asignado
 * @property Carbon|null $fecha_carga
 * @property Carbon|null $fecha_descarga
 *
 *
 * @property Paquete $paquete
 * @property Vehiculo|null $vehiculo
 *
 * @package App\Models
 */
class Trae extends Model
{
	protected $table = 'TRAE';
	protected $primaryKey = 'ID_paquete';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_paquete' => 'int',
		'fecha_asignado' => 'datetime',
		'fecha_carga' => 'datetime',
		'fecha_descarga' => 'datetime'
	];

	protected $fillable = [
		'matricula',
		'fecha_asignado',
		'fecha_carga',
		'fecha_descarga'
	];

	public function paquete()
	{
		return $this->belongsTo(Paquete::class, 'ID_paquete');
	}

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class, 'matricula');
	}
}
