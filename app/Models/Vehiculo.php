<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehiculo
 * 
 * @property string $matricula
 * @property int $vol_max
 * @property int $peso_max
 * @property bool $es_operativo
 * @property bool $baja
 * 
 * @property Camion $camion
 * @property Camioneta $camioneta
 * @property Collection|Conducen[] $conducens
 * @property Collection|Trae[] $traes
 *
 * @package App\Models
 */
class Vehiculo extends Model
{
	protected $table = 'vehiculos';
	protected $primaryKey = 'matricula';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'vol_max' => 'int',
		'peso_max' => 'int',
		'es_operativo' => 'bool',
		'baja' => 'bool'
	];

	protected $fillable = [
		'vol_max',
		'peso_max',
		'es_operativo',
		'baja'
	];

	public function camion()
	{
		return $this->hasOne(Camion::class, 'matricula');
	}

	public function camioneta()
	{
		return $this->hasOne(Camioneta::class, 'matricula');
	}

	public function conducens()
	{
		return $this->hasMany(Conducen::class, 'matricula');
	}

	public function traes()
	{
		return $this->hasMany(Trae::class, 'matricula');
	}
}
