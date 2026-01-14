<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'completed',
        'user_id',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearchByStatus($query, bool $status): Builder
    {
        return $query->where('completed', $status);
    }

    public function scopeSearchByTitle($query, string $title): Builder
    {
        return $query->where('title', 'ilike', '%' . $title . '%');
    }

    public function scopeOwnedBy($query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
