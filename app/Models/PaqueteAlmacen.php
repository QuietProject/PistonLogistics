<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaqueteAlmacen
 * 
 * @property int $ID_paquete
 * @property int $ID_almacen
 * @property Carbon $desde
 * @property Carbon|null $hasta
 * 
 * @property Paquete $paquete
 * @property AlmacenPropio $almacen_propio
 *
 * @package App\Models
 */
class PaqueteAlmacen extends Model
{
	protected $table = 'paquetes_almacenes';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_paquete' => 'int',
		'ID_almacen' => 'int',
		'desde' => 'datetime',
		'hasta' => 'datetime'
	];

	protected $fillable = [
		'hasta'
	];

	public function paquete()
	{
		return $this->belongsTo(Paquete::class, 'ID_paquete');
	}

	public function almacen_propio()
	{
		return $this->belongsTo(AlmacenPropio::class, 'ID_almacen');
	}
}
