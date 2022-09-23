<?php

namespace App\Models;

use App\Core\HasLogsActivity;
use App\Core\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model implements HasLogsActivity
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'owner_id',
        'ticket_id',
        'content'
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

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function __toString(): string
    {
        return $this->content;
    }

    public function activityLogLink(): string
    {
        return route('tickets.number', $this->ticket->ticket_number);
    }
}
