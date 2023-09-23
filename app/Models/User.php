<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property string $user
 * @property string $password
 * @property int $rol
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

	protected $table = 'users';
	protected $primaryKey = 'user';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'rol' => 'int'
	];

	protected $hidden = [
		'password',
        'remember_token'
	];

	protected $fillable = [
		'user',
        'password',
		'rol'
	];
}
