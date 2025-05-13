<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Проверка, является ли пользователь администратором
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->status === 'admin';
    }

    /**
     * Нормализовать формат телефона перед сохранением
     *
     * @param string $value
     * @return void
     */
    public function setPhoneAttribute($value)
    {
        // Сохраняем телефон в исходном формате
        $this->attributes['phone'] = $value;
    }

    /**
     * Получить телефон в форматированном виде
     *
     * @param string $value
     * @return string
     */
    public function getPhoneFormattedAttribute()
    {
        return $this->phone;
    }
}
