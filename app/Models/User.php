<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    static $rules = [
        'name',
        'email',
        'password',
        'legitimado',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'legitimado',
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
        'password' => 'hashed',
    ];

    public function estaLegitimado()
    {
        return $this->legitimado;
    }

    public function votes()
    {
        return $this->belongsToMany(CommunityLink::class, 'community_link_users')->withTimestamps();
    }

    public function votedFor(CommunityLink $link)
    {
        return $this->votes->contains($link);
    }

    public function profile() {
        return $this->hasOne(Profile::class);
    }
}
