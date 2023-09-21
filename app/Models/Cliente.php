<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 * 
 * @property string $RUT
 * @property string $nombre
 * @property bool $baja
 * 
 * @property Collection|Almacene[] $almacenes
 *
 * @package App\Models
 */
class Cliente extends Model
{
	protected $table = 'clientes';
	protected $primaryKey = 'RUT';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'baja' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'baja'
	];

	public function almacenes()
	{
		return $this->belongsToMany(Almacene::class, 'almacenes_clientes', 'RUT', 'ID');
	}
}
