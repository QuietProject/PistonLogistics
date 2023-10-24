<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lote
 * 
 * @property int $ID
 * @property int $ID_troncal
 * @property int $ID_almacen
 * @property bool $tipo
 * 
 * @property Orden $orden
 * @property DestinoLote $destino_lote
 * @property Collection|Estado[] $estados
 * @property Lleva $lleva
 * @property Collection|Paquete[] $paquetes
 *
 * @package App\Models
 */
class Lote extends Model
{
	protected $table = 'lotes';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'ID_troncal' => 'int',
		'ID_almacen' => 'int',
		'tipo' => 'bool'
	];

	protected $fillable = [
		'ID_troncal',
		'ID_almacen',
		'tipo'
	];

	public function orden()
	{
		return $this->belongsTo(Orden::class, 'ID_troncal', 'ID_almacen');
	}

	public function destino_lote()
	{
		return $this->hasOne(DestinoLote::class, 'ID_lote');
	}

	public function estados()
	{
		return $this->hasMany(Estado::class, 'ID_lote');
	}

	public function lleva()
	{
		return $this->hasOne(Lleva::class, 'ID_lote');
	}

	public function paquetes()
	{
		return $this->hasMany(Paquete::class, 'paquetes_lotes', 'ID_lote', 'ID_paquete')
        ->select('paquetes.*', 'paquetes_lotes.fecha as fecha_pivot');
	}
}
