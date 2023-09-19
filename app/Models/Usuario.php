<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property string $usuario
 * @property string $pass
 * @property int $rol
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuarios';
	protected $primaryKey = 'usuario';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'rol' => 'int'
	];

	protected $fillable = [
		'pass',
		'rol'
	];
}
