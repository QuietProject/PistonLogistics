<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Lote
 * 
 * @property int $ID
 * @property int $ID_troncal
 * @property int $ID_almacen
 * @property Carbon $fecha_creacion
 * @property Carbon|null $fecha_pronto
 * @property Carbon|null $fecha_cerrado
 * @property bool $tipo
 * 
 * @property Orden $orden
 * @property DestinoLote $destino_lote
 * @property Lleva $lleva
 * @property Collection|Paquete[] $paquetes
 *
 * @package App\Models
 */
class Lote extends Model
{
	protected $table = 'LOTES';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'ID_troncal' => 'int',
		'ID_almacen' => 'int',
		'fecha_creacion' => 'datetime',
		'fecha_pronto' => 'datetime',
		'fecha_cerrado' => 'datetime',
		'tipo' => 'bool'
	];

	protected $fillable = [
		'ID_troncal',
		'ID_almacen',
		'fecha_creacion',
		'fecha_pronto',
		'fecha_cerrado',
		'tipo',
		'codigo'
	];

	public static function getCodigo(){
		do {
			$codigo = "L" . Str::random(7);
		} while (self::where('codigo', $codigo)->exists());
		return $codigo;
	}

	protected static function boot()
	{
		parent::boot();

		static::creating(function ($model) {
			do {
				$codigo = "L" . Str::random(7);
			} while (self::where('codigo', $codigo)->exists());

			$model->codigo = $codigo;
		});
	}

	public function orden()
	{
		return $this->belongsTo(Orden::class, 'ID_almacen')
					->where('ordenes.ID_almacen', '=', 'lotes.ID_almacen')
					->where('ordenes.ID_troncal', '=', 'lotes.ID_troncal');
	}

	public function destino_lote()
	{
		return $this->hasOne(DestinoLote::class, 'ID_lote');
	}

	public function lleva()
	{
		return $this->hasOne(Lleva::class, 'ID_lote');
	}

	public function paquetes()
	{
		return $this->belongsToMany(Paquete::class, 'paquetes_lotes', 'ID_lote', 'ID_paquete')
					->withPivot('desde', 'hasta');
	}
}
