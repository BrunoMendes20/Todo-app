<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword as resetPasswordBase;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];

    protected static function booted()
    {
        resetPasswordBase::toMailUsing(function ($notifiable, $token) {
            return (new CustomResetPassword($token))
            ->toMail($notifiable);
        });
    }
}
