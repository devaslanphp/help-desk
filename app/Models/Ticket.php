<?php

namespace App\Models;

use App\Core\HasLogsActivity;
use App\Core\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model implements HasLogsActivity
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'title',
        'content',
        'status',
        'priority',
        'type',
        'owner_id',
        'responsible_id',
        'project_id',
        'number',
    ];

    protected $appends = [
        'ticket_number'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
        static::creating(function (Ticket $ticket) {
            $ticket->number = str_pad(
                Ticket::where('project_id', $ticket->project_id)
                        ->withTrashed()
                        ->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id')->withTrashed();
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id')->withTrashed();
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function ticketNumber(): Attribute
    {
        return new Attribute(
            get: fn() => $this->project?->ticket_prefix . '' . $this->number
        );
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function activityLogLink(): string
    {
        return route('tickets.number', $this->ticket_number);
    }

    public function chat(): HasOne
    {
        return $this->hasOne(Chat::class);
    }

}
