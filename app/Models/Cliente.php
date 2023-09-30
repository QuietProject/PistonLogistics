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
 * @property Collection|Almacen[] $almacenes
 * @property Collection|Almacen_cliente[] $almacenes_cliente
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
		'RUT',
		'nombre',
		'baja'
	];

	public function almacenes()
	{
		return $this->belongsToMany(Almacen::class, 'almacenes_clientes', 'RUT', 'ID');
	}

    public function almacenes_cliente()
	{
		return $this->belongsToMany(AlmacenCliente::class, 'RUT'
    );
	}
}
