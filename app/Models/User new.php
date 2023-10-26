<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property string $user
 * @property string|null $password
 * @property int $rol
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $remember_token
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'user';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'rol' => 'int',
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'password',
		'rol',
		'email',
		'email_verified_at',
		'remember_token'
	];
}
