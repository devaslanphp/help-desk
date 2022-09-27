<?php

namespace App\Models;

use App\Core\HasLogsActivity;
use App\Core\LogsActivity;
use Devaslanphp\FilamentAvatar\Core\HasAvatarUrl;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasLogsActivity
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword, SoftDeletes, LogsActivity, HasAvatarUrl, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'register_token',
        'locale',
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
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'owner_id');
    }

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'responsible_id');
    }

    public function favoriteProjects(): BelongsToMany
    {
        $query = $this->belongsToMany(Project::class, 'favorite_projects', 'user_id', 'project_id');
        if (auth()->user()->can('View own projects') && !auth()->user()->can('View all projects')) {
            $query->where('user_id', auth()->user()->id);
        }
        return $query;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'owner_id');
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function activityLogLink(): string
    {
        return route('administration.users');
    }

    public function isAccountActivated(): Attribute
    {
        return new Attribute(
            get: fn() => $this->register_token == null
        );
    }

    public function ownCompanies(): HasMany
    {
        return $this->hasMany(Company::class, 'responsible_id');
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_users', 'user_id', 'company_id');
    }
}
