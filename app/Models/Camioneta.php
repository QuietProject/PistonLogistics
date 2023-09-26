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
 * @property Collection|Reparte[] $reparte
 *
 * @package App\Models
 */
class Camioneta extends Model
{
	protected $table = 'camionetas';
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

	public function reparte()
	{
		return $this->hasMany(Reparte::class, 'matricula');
	}
}
