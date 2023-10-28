<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaqueteLote
 * 
 * @property int $ID_paquete
 * @property int $ID_lote
 * @property Carbon $desde
 * @property Carbon|null $hasta
 * 
 * @property Paquete $paquete
 * @property Lote $lote
 *
 * @package App\Models
 */
class PaqueteLote extends Model
{
	protected $table = 'paquetes_lotes';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'ID_paquete' => 'int',
		'ID_lote' => 'int',
		'desde' => 'datetime',
		'hasta' => 'datetime'
	];

	protected $fillable = [
		'desde',
		'hasta'
	];

	public function paquete()
	{
		return $this->belongsTo(Paquete::class, 'ID_paquete');
	}

	public function lote()
	{
		return $this->belongsTo(Lote::class, 'ID_lote');
	}
}
