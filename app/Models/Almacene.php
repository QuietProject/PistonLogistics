<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Almacene
 * 
 * @property int $ID
 * @property string $nombre
 * @property string $direccion
 * @property bool $baja
 * 
 * @property Collection|Cliente[] $clientes
 * @property AlmacenesPropio $almacenes_propio
 *
 * @package App\Models
 */
class Almacene extends Model
{
	protected $table = 'almacenes';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'baja' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'direccion',
		'baja'
	];

	public function clientes()
	{
		return $this->belongsToMany(Cliente::class, 'almacenes_clientes', 'ID', 'RUT');
	}

	public function almacenes_propio()
	{
		return $this->hasOne(AlmacenesPropio::class, 'ID');
	}
}
