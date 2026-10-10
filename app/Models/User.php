<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject; // 1. استيراد واجهة JWT

class User extends Authenticatable implements JWTSubject // 2. تطبيق الواجهة
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'fullname',
        'phone',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'roles', // إخفاء مصفوفة الأدوار المعقدة لنعيدها بشكل نظيف
    ];

    // لإضافة خاصية 'role' تلقائياً عند تحويل المودل إلى JSON
    protected $appends = ['role'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- أساليب JWT المباشرة ---

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role, // تضمين الدور داخل التوكين
        ];
    }

    // --- Accessor لجلب اسم الدور بشكل مباشر (trainer / player) ---
    public function getRoleAttribute()
    {
        // يرجع أول دور مخصص للمستخدم (مثل 'trainer' أو 'player')
        return $this->getRoleNames()->first() ?? 'player';
    }

    public function player(): HasOne
    {
        return $this->hasOne(Player::class);
    }
    public function staff(): HasOne
    {
        return $this->hasOne(Staff::class);
    }
    public function internalRequests(): HasMany
    {
        return $this->hasMany(
            InternalRequest::class,
            'requested_by'
        );
    }
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
