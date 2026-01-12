<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import trait ini

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    use SoftDeletes; // 2. Gunakan trait ini di dalam class


    protected $dates = ['deleted_at']; // 3. Daftarkan kolomnya (opsional di Laravel versi terbaru, tapi bagus buat kejelasan)
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    const ROLE_ADMIN = 'admin';
    const ROLE_MEMBER = 'user';

     public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isMember()
    {
        return $this->role === self::ROLE_MEMBER;
    }

    public function getRoleLabelAttribute()
    {
        return $this->role === self::ROLE_ADMIN ? 'Administrator' : 'Customer';
    }

    public function getRoleColorAttribute()
    {
        return $this->role === self::ROLE_ADMIN 
            ? 'bg-accent-blue text-white' 
            : 'bg-accent-pink text-primary-primaryBlue';
    }


    protected static function booted()
    {
        static::deleting(function ($user) {
            if (!$user->isForceDeleting()) { // Cek kalau ini Soft Delete, bukan hapus permanen
                $user->update([
                    'email' => $user->email . '::deleted::' . now()->timestamp
                ]);
            }
        });
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
