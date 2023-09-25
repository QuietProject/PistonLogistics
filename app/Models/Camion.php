<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Camion
 *
 * @property string $matricula
 *
 * @property Vehiculo $vehiculo
 * @property Collection|Lleva[] $llevas
 *
 * @package App\Models
 */
class Camion extends Model
{
	protected $table = 'camiones';
	protected $primaryKey = 'matricula';
	public $incrementing = false;
	public $timestamps = false;

    protected $fillable = [
		'matricula'
	];

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class, 'matricula');
	}

	public function lleva()
	{
		return $this->hasMany(Lleva::class, 'matricula');
	}
}
