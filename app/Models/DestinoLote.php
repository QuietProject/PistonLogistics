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
 * @property Ordene $ordene
 *
 * @package App\Models
 */
class DestinoLote extends Model
{
	protected $table = 'destino_lote';
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

	public function ordene()
	{
		return $this->belongsTo(Ordene::class, 'ID_almacen')
					->where('ordenes.ID_almacen', '=', 'destino_lote.ID_almacen')
					->where('ordenes.ID_troncal', '=', 'destino_lote.ID_troncal');
	}
}
