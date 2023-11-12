<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Troncale
 * 
 * @property int $ID
 * @property string $nombre
 * @property bool $baja
 * 
 * @property Collection|Orden[] $ordenes
 *
 * @package App\Models
 */
class Troncal extends Model
{
	protected $table = 'TRONCALES';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'baja' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'baja'
	];

	public function ordenes()
	{
		return $this->hasMany(Orden::class, 'ID_troncal');
	}
}
