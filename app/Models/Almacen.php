<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Almacen
 * 
 * @property int $ID
 * @property string $nombre
 * @property string $direccion
 * @property float $longitud
 * @property float $latitud
 * @property bool $baja
 * 
 * @property Collection|Cliente[] $clientes
 * @property AlmacenPropio $almacen_propio
 * @property AlmacenCliente $almacen_cliente
 *
 * @package App\Models
 */
class Almacen extends Model
{
	protected $table = 'ALMACENES';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'longitud' => 'float',
		'latitud' => 'float',
		'baja' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'direccion',
		'longitud',
		'latitud'
	];

	public function clientes()
	{
		return $this->belongsToMany(Cliente::class, 'almacenes_clientes', 'ID', 'RUT');
	}

	public function almacen_propio()
	{
		return $this->hasOne(AlmacenPropio::class, 'ID');
	}

	public function almacen_cliente()
	{
		return $this->hasOne(AlmacenCliente::class, 'ID');
	}
}
