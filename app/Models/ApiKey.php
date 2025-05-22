<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiKey extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'key',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($apiKey) {
            $apiKey->uuid = (string) \Illuminate\Support\Str::uuid();
            $apiKey->key = bin2hex(random_bytes(32));
        });
    }
}
