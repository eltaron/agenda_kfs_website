<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // 1. أضف هذا السطر هنا

class User extends Authenticatable
{

    use  HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
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
    // أضف هذه العلاقات داخل كلاس User
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // الاجتماعات التي أنشأها المستخدم
    public function createdMeetings()
    {
        return $this->hasMany(Meeting::class, 'created_by');
    }

    // الاجتماعات التي دُعي إليها المستخدم
    public function attendingMeetings()
    {
        return $this->belongsToMany(Meeting::class);
    }
}
