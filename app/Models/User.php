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
        'password',
        'phone',
        'address',
        'avatar',
        'role',
        'is_active',
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
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the avatar URL attribute.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && file_exists(storage_path('app/public/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }
        
        // Return default avatar based on user's initial
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
    
    /**
     * Check if user has admin role
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    /**
     * Check if user has editor role
     */
    public function isEditor()
    {
        return $this->role === 'editor';
    }
    
    /**
     * Check if user has viewer role
     */
    public function isViewer()
    {
        return $this->role === 'viewer';
    }
    
    /**
     * Check if user has specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }
    
    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole($roles)
    {
        return in_array($this->role, (array) $roles);
    }
    
    /**
     * Check if user can access admin panel
     */
    public function canAccessAdmin()
    {
        return $this->is_active && in_array($this->role, ['admin', 'editor']);
    }
    
    /**
     * Get role display name
     */
    public function getRoleDisplayNameAttribute()
    {
        $roles = [
            'admin' => 'Administrator',
            'editor' => 'Editor',
            'viewer' => 'Viewer',
            'student' => 'Mahasiswa',
            'lecturer' => 'Dosen'
        ];
        
        return $roles[$this->role] ?? ucfirst($this->role);
    }
}
