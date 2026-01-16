<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;

class User extends Authenticatable implements MustVerifyEmail
{
    // Enables model factories and notification capabilities
    use HasFactory, Notifiable;

    /**
     * Define the relationship between User and Task.
     * A user can have many tasks.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * The attributes that are mass assignable.
     * These fields can be safely assigned via create() or update().
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden when the model
     * is serialized (arrays or JSON).
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Bootstrap any model services.
     * Customize the password reset notification email.
     */
    protected static function booted()
    {
        // Override the default password reset email
        ResetPasswordBase::toMailUsing(function ($notifiable, $token) {
            return (new CustomResetPassword($token))
                ->toMail($notifiable);
        });
    }
}
