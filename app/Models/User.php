<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    static $roles = ['DEVELOPER', 'ADMIN', 'USER', 'SUSPENDED'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function getRouteKeyName()
    {
        return 'email';
    }

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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function postsPercent()
    {
        if (Post::count() == 0) {
            return 100;
        }
        return $this->posts()->count() * 100 / Post::count();
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function productsPercent()
    {

        if (Product::count() == 0) {
            return 100;
        }
        return $this->products()->count() * 100 / Product::count();
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function ticketsPercent()
    {
        if (Ticket::count() == 0) {
            return 100;
        }
        return $this->tickets()->count() * 100 / Ticket::count();
    }
    public function comments()
    {
        return $this->morphMany(Comment::class,'commentator');
    }

    public function commentsPercent()
    {
        if (Comment::count() == 0) {
            return 100;
        }
        return $this->comments()->count() * 100 / Comment::count();
    }

    public function logs()
    {
        return $this->hasMany(AdminLog::class, 'user_id', 'id');
    }
}
