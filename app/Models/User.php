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
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string|null $remember_token
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
		'rol' => 'int',
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
        'remember_token'
	];

	protected $fillable = [
		'user',
        'password',
		'email',
		'email_verified_at',
		'rol'
	];
}
