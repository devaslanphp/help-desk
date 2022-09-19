<?php

namespace App\Models;

use App\Core\HasLogsActivity;
use App\Core\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketStatus extends Model implements HasLogsActivity
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'title',
        'text_color',
        'bg_color',
        'default',
        'slug'
    ];

    public function __toString(): string
    {
        return $this->title;
    }

    public function activityLogLink(): string
    {
        return route('administration.ticket-statuses');
    }
}
