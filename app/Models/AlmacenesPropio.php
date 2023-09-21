<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AlmacenesPropio
 * 
 * @property int $ID
 * 
 * @property Almacene $almacene
 * @property Collection|Ordene[] $ordenes
 * @property Collection|Paquete[] $paquetes
 *
 * @package App\Models
 */
class AlmacenesPropio extends Model
{
	protected $table = 'almacenes_propios';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID' => 'int'
	];

	public function almacene()
	{
		return $this->belongsTo(Almacene::class, 'ID');
	}

	public function ordenes()
	{
		return $this->hasMany(Ordene::class, 'ID_almacen');
	}

	public function paquetes()
	{
		return $this->hasMany(Paquete::class, 'ID_pickup');
	}
}
