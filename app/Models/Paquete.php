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
 * @property string|null $direccion
 * @property int|null $peso
 * @property int|null $volumen
 * @property Carbon|null $fecha_entregado
 * @property string|null $mail
 * @property string|null $cedula
 * @property int $estado
 * 
 * @property AlmacenCliente $almacen_cliente
 * @property AlmacenPropio $almacen_propio
 * @property Collection|PaquetesAlmacene[] $paquetes_almacenes
 * @property Collection|Lote[] $lotes
 * @property Reparte $reparte
 * @property Trae $trae
 *
 * @package App\Models
 */
class Paquete extends Model
{
	protected $table = 'PAQUETES';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'ID_almacen' => 'int',
		'fecha_registrado' => 'datetime',
		'ID_pickup' => 'int',
		'peso' => 'int',
		'volumen' => 'int',
		'fecha_entregado' => 'datetime',
		'estado' => 'int'
	];

	protected $fillable = [
		'ID_almacen',
		'fecha_registrado',
		'ID_pickup',
		'direccion',
		'peso',
		'volumen',
		'fecha_entregado',
		'mail',
		'cedula',
		'estado'
	];

	public function almacen_cliente()
	{
		return $this->belongsTo(AlmacenCliente::class, 'ID_almacen');
	}

	public function almacen_propio()
	{
		return $this->belongsTo(AlmacenPropio::class, 'ID_pickup');
	}


	public function paquetes_almacenes()
	{
		return $this->hasMany(PaquetesAlmacene::class, 'ID_paquete');
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
