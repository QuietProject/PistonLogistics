<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Camionero
 * 
 * @property string $CI
 * @property string $nombre
 * @property string $apellido
 * 
 * @property Collection|Conduce[] $conduceVarios
 *
 * @package App\Models
 */
class Camionero extends Model
{
	protected $table = 'CAMIONEROS';
	protected $primaryKey = 'CI';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'apellido'
	];

	public function conduceVarios()
	{
		return $this->hasMany(Conduce::class, 'CI');
	}
}
