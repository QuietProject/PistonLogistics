<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ordene
 * 
 * @property int $ID_almacen
 * @property int $ID_troncal
 * @property int|null $orden
 * 
 * @property AlmacenPropio $almacen_propio
 * @property Troncale $troncale
 * @property Collection|DestinoLote[] $destino_lotes
 * @property Collection|Lote[] $lotes
 *
 * @package App\Models
 */
class Orden extends Model
{
	protected $table = 'ordenes';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_almacen' => 'int',
		'ID_troncal' => 'int',
		'orden' => 'int'
	];

	protected $fillable = [
		'orden'
	];

	public function almacenes_propio()
	{
		return $this->belongsTo(AlmacenesPropio::class, 'ID_almacen');
	}

	public function troncale()
	{
		return $this->belongsTo(Troncale::class, 'ID_troncal');
	}

	public function destino_lotes()
	{
		return $this->hasMany(DestinoLote::class, 'ID_almacen');
	}

	public function lotes()
	{
		return $this->hasMany(Lote::class, 'ID_almacen');
	}
}
