<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Conducen
 *
 * @property string $CI
 * @property string $matricula
 * @property Carbon $desde
 * @property Carbon|null $hasta
 *
 * @property Camionero $camionero
 * @property Vehiculo $vehiculo
 *
 * @package App\Models
 */
class Conducen extends Model
{
	protected $table = 'conducen';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'desde' => 'datetime',
		'hasta' => 'datetime'
	];

	protected $fillable = [
		'CI',
        'matricula'
	];

	public function camionero()
	{
		return $this->belongsTo(Camionero::class, 'CI');
	}

	public function vehiculo()
	{
		return $this->belongsTo(Vehiculo::class, 'matricula');
	}
}
