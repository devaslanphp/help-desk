<?php

namespace App\Models;

use App\Core\HasLogsActivity;
use App\Core\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model implements HasLogsActivity
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'ticket_prefix',
        'company_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id')->withTrashed();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function favoriteUsers(): BelongsToMany
    {
        $query = $this->belongsToMany(User::class, 'favorite_projects', 'project_id', 'user_id');
        if (auth()->user()->can('View own projects') && !auth()->user()->can('View all projects')) {
            $query->where('user_id', auth()->user()->id);
        }
        return $query;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function activityLogLink(): string
    {
        return route('home');
    }
}
