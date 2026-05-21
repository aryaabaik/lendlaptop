<?php

namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected $fillable = [
    'name', 'email', 'password', 'role', 'kelas', 'phone'
    ];
    
    /**
     * Check if the user has an admin role.
     * Adjust this logic based on your actual role implementation (e.g., 'role' column, roles relationship).
     */
    public function isAdmin()
    {
        return $this->role === 'admin'; // Example: assumes a 'role' column with 'admin' value
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function notifications() {
    return $this->hasMany(Notification::class)->latest();
}

public function unreadNotifications() {
    return $this->notifications()->where('is_read', false);
}
}

