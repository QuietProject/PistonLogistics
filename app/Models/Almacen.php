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
 * @property string $calle
 * @property string $numero
 * @property float $latitud
 * @property float $longitud
 * @property bool $baja
 * 
 * @property Collection|Cliente[] $clientes
 * @property AlmacenPropio $almacen_propio
 *
 * @package App\Models
 */
class Almacene extends Model
{
	protected $table = 'almacenes';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'latitud' => 'float',
		'longitud' => 'float',
		'baja' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'calle',
		'numero',
		'latitud',
		'longitud',
		'baja'
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'almacenes_clientes', 'ID', 'RUT');
	}

	public function almacen_propio()
	{
		return $this->hasOne(AlmacenPropio::class, 'ID');
	}
}
