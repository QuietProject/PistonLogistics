<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DestinoLote
 *
 * @property int $ID_lote
 * @property int $ID_almacen
 * @property int $ID_troncal
 *
 * @property Lote $lote
 * @property Orden $orden
 *
 * @package App\Models
 */
class DestinoLote extends Model
{
	protected $table = 'DESTINO_LOTE';
	protected $primaryKey = 'ID_lote';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_lote' => 'int',
		'ID_almacen' => 'int',
		'ID_troncal' => 'int'
	];

	protected $fillable = [
		'ID_almacen',
		'ID_troncal'
	];

	public function lote()
	{
		return $this->belongsTo(Lote::class, 'ID_lote');
	}

	public function orden()
	{
		return $this->belongsTo(Orden::class, 'ID_almacen')
					->where('ORDENES.ID_almacen', '=', 'DESTINO_LOTE.ID_almacen')
					->where('ORDENES.ID_troncal', '=', 'DESTINO_LOTE.ID_troncal');
	}
}
