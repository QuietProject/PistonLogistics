<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AlmacenesCliente
 * 
 * @property int $ID
 * @property string $RUT
 * 
 * @property Almacene $almacene
 * @property Cliente $cliente
 * @property Collection|Paquete[] $paquetes
 *
 * @package App\Models
 */
class AlmacenesCliente extends Model
{
	protected $table = 'almacenes_clientes';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int'
	];

	protected $fillable = [
		'RUT'
	];

	public function almacen()
	{
		return $this->belongsTo(Almacene::class, 'ID');
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'RUT');
	}

	public function paquetes()
	{
		return $this->hasMany(Paquete::class, 'ID_almacen');
	}
}
