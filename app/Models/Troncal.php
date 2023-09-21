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
 * @property Collection|Ordene[] $ordenes
 *
 * @package App\Models
 */
class Troncal extends Model
{
	protected $table = 'troncales';
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
		return $this->hasMany(Ordene::class, 'ID_troncal');
	}
}
