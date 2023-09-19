<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Paquete
 * 
 * @property int $ID
 * @property int $ID_almacen
 * @property Carbon $fecha_registrado
 * @property int $ID_pickup
 * @property string|null $calle
 * @property string|null $numero
 * @property string|null $ciudad
 * @property int|null $peso
 * @property int|null $volumen
 * @property Carbon|null $fecha_recibido
 * @property string|null $mail
 * @property string|null $cedula
 * 
 * @property AlmacenCliente $almacen_cliente
 * @property AlmacenPropio $almacen_propio
 * @property Collection|Lote[] $lotes
 * @property Reparte $reparte
 * @property Trae $trae
 *
 * @package App\Models
 */
class Paquete extends Model
{
	protected $table = 'paquetes';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'ID_almacen' => 'int',
		'fecha_registrado' => 'datetime',
		'ID_pickup' => 'int',
		'peso' => 'int',
		'volumen' => 'int',
		'fecha_recibido' => 'datetime'
	];

	protected $fillable = [
		'ID_almacen',
		'fecha_registrado',
		'ID_pickup',
		'calle',
		'numero',
		'ciudad',
		'peso',
		'volumen',
		'fecha_recibido',
		'mail',
		'cedula'
	];

	public function almacen_cliente()
	{
		return $this->belongsTo(AlmacenCliente::class, 'ID_almacen');
	}

	public function almacen_propio()
	{
		return $this->belongsTo(AlmacenesPropio::class, 'ID_pickup');
	}

	public function lotes()
	{
		return $this->belongsToMany(Lote::class, 'paquetes_lotes', 'ID_paquete', 'ID_lote')
					->withPivot('fecha');
	}

	public function reparte()
	{
		return $this->hasOne(Reparte::class, 'ID_paquete');
	}

	public function trae()
	{
		return $this->hasOne(Trae::class, 'ID_paquete');
	}
}
