<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'owner_id'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_projects', 'project_id', 'user_id')->withPivot('role');
    }

    public function favoriteUsers(): BelongsToMany
    {
        $query = $this->belongsToMany(User::class, 'favorite_projects', 'project_id', 'user_id');
        if (has_all_permissions(auth()->user(), 'view-own-projects') && !has_all_permissions(auth()->user(), 'view-all-projects')) {
            $query->where('owner_id', auth()->user()->id);
        }
        return $query;
    }
}
