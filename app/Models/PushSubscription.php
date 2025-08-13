<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'endpoint',
        'public_key',
        'auth_token',
        'content_encoding',
        'user_id'
    ];

    /**
     * Get the user that owns this subscription
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
