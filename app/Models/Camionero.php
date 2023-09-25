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
 * @property bool $baja
 *
 * @property Collection|Conducen[] $conducens
 *
 * @package App\Models
 */
class Camionero extends Model
{
	protected $table = 'camioneros';
	protected $primaryKey = 'CI';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'baja' => 'bool'
	];

	protected $fillable = [
		'CI',
        'nombre',
		'apellido',
		'baja'
	];

	public function conduce()
	{
		return $this->hasMany(Conducen::class, 'CI');
	}
}
