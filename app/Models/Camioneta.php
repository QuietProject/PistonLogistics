<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Camioneta
 * 
 * @property string $matricula
 * 
 * @property Vehiculo $vehiculo
 * @property Collection|Reparte[] $reparteVarios
 *
 * @package App\Models
 */
class Camioneta extends Model
{
	protected $table = 'camionetas';
	protected $primaryKey = 'matricula';
	public $incrementing = false;
	public $timestamps = false;

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class, 'matricula');
	}

	public function reparteVarios()
	{
		return $this->hasMany(Reparte::class, 'matricula');
	}
}
