<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

	public $timestamps = false;
    protected $primaryKey = 'user';
	public $incrementing = false;

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

	public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}