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
 * @property bool $baja
 * 
 * @property Collection|Conducen[] $conducen
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
		'nombre',
		'baja'
	];

	public function conducen()
	{
		return $this->hasMany(Conducen::class, 'CI');
	}
}
