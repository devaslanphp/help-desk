<?php

namespace App\Http\Livewire;

use App\Jobs\TicketUpdatedJob;
use App\Models\Ticket;
use App\Models\TicketPriority;
use App\Models\TicketType;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use InvadersXX\FilamentKanbanBoard\Pages\FilamentKanbanBoard;

class Kanban extends FilamentKanbanBoard
{
    protected static ?string $title = '';
    public bool $sortable = true;
    public bool $sortableBetweenStatuses = true;
    public bool $recordClickEnabled = true;

    /**
     * Statuses list Definition
     *
     * @return Collection
     */
    protected function statuses(): Collection
    {
        return collect(statuses_list_for_kanban());
    }

    /**
     * Records list definitino
     *
     * @return Collection
     */
    protected function records(): Collection
    {
        $query = Ticket::query();
        $query->withCount('comments');
        if (auth()->user()->can('View own tickets') && !auth()->user()->can('View all tickets')) {
            $query->where(function ($query) {
                $query->where('owner_id', auth()->user()->id)
                    ->orWhere('responsible_id', auth()->user()->id)
                    ->orWhereHas('project', function ($query) {
                        $query->whereHas('company', function ($query) {
                            $query->whereIn('companies.id', auth()->user()->ownCompanies->pluck('id')->toArray());
                        });
                    });
            });
        }
        return $query->get()
            ->map(function (Ticket $ticket) {
                $priority = TicketPriority::where('slug', $ticket->priority)->withTrashed()->first();
                $type = TicketType::where('slug', $ticket->type)->withTrashed()->first();
                return [
                    'id' => $ticket->id,
                    'title' => new HtmlString('
                        <div class="w-full flex flex-col space-y-3">
                            <div class="w-full flex items-center gap-2">
                                ' . ($type ? '
                                    <div title="' . $type['title'] . '"
                                        class="text-xs rounded-full w-6 h-6 flex items-center
                                            justify-center text-center"
                                        style="color: ' . $type->text_color . ';
                                            background-color: ' . $type->bg_color . ';"
                                        >
                                        <i class="fa ' . $type['icon'] . '"></i>
                                    </div>
                                ' : '') . '
                                ' . ($priority ? '
                                    <div title="' . $priority['title'] . '"
                                        class="text-xs rounded-full w-6 h-6 flex items-center
                                            justify-center text-center"
                                        style="
                                            color: ' . $priority->text_color . ';
                                            background-color: ' . $priority->bg_color . ';
                                        "
                                        >
                                        <i class="fa ' . $priority['icon'] . '"></i>
                                    </div>
                                ' : '') . '
                                <span class="text-sm font-normal"
                                    title="' . $ticket->title . '">
                                    ' . Str::limit($ticket->title, 15) . '
                                </span>
                            </div>
                            <div class="w-full text-xs font-light">
                                ' . Str::limit(htmlspecialchars(strip_tags($ticket->content))) . '
                            </div>
                            <div class="w-full flex items-center space-x-4">
                                <div class="flex items-center gap-1">
                                    ' .
                                        ($ticket->responsible ? '
                                            <img src="' . $ticket->responsible->avatar_url . '"
                                                alt="' . $ticket->responsible->name . '"
                                                class="rounded-full shadow"
                                                style="width: 20px; height: 20px;"
                                            />
                                            <span class="font-light text-xs">' . $ticket->responsible->name . '</span>
                                        ' : '<span class="text-xs font-normal text-gray-400">
                                                ' . __('Not assigned yet!') .
                                            '</span>')
                        . '
                                </div>
                                <div class="flex items-center gap-1 text-xs text-gray-500">
                                    ' . $ticket->comments_count . '
                                    <i class="fa fa-comment-o"></i>
                                </div>
                            </div>
                        </div>
                    '),
                    'status' => $ticket->status,
                ];
            });
    }

    /**
     * Customizing kanban board styles
     *
     * @return string[]
     */
    protected function styles(): array
    {
        return [
            'wrapper' => 'w-full h-full flex space-x-4 overflow-x-auto',
            'kanbanWrapper' => 'h-full flex-1',
            'kanban' => 'border border-gray-150 flex flex-col h-full rounded',
            'kanbanHeader' => 'px-3 py-3 font-bold text-xs w-full border-b border-gray-150',
            'kanbanFooter' => '',
            'kanbanRecords' => 'space-y-4 p-3 flex-1 overflow-y-auto w-64',
            'record' => 'bg-white dark:bg-gray-800 p-4 border border-gray-150 rounded
                        cursor-pointer w-62 hover:bg-gray-50 hover:shadow-lg',
            'recordContent' => 'w-full',
        ];
    }

    /**
     * Event launched when the record status is changed
     *
     * @param $recordId
     * @param $statusId
     * @param $fromOrderedIds
     * @param $toOrderedIds
     * @return void
     */
    public function onStatusChanged($recordId, $statusId, $fromOrderedIds, $toOrderedIds): void
    {
        $ticket = Ticket::find($recordId);
        if (
            (
                auth()->user()->can('Update all tickets')
                || (
                    auth()->user()->can('Update own tickets')
                    && (
                        $ticket->owner_id === auth()->user()
                        || $ticket->responsible_id === auth()->user()->id)
                )
            )
            && auth()->user()->can('Change status tickets')
        ) {
            $before = __(config('system.statuses.' . $ticket->status . '.title')) ?? '-';
            $ticket->status = $statusId;
            $ticket->save();
            Notification::make()
                ->success()
                ->title(__('Status updated'))
                ->body(__('The ticket status has been successfully updated'))
                ->send();
            TicketUpdatedJob::dispatch(
                $ticket,
                __('Status'),
                $before,
                __(config('system.statuses.' . $ticket->status . '.title') ?? '-'),
                auth()->user()
            );
        } else {
            Notification::make()
                ->success()
                ->title(__('Oops!'))
                ->body(__("You don't have permissions to change this ticket status"))
                ->send();
        }
    }

    /**
     * Event launched when the record is clicked
     *
     * @param $recordId
     * @return void
     */
    public function onRecordClick($recordId): void
    {
        $ticket = Ticket::find($recordId);
        $url = route('tickets.details', ['ticket' => $ticket, 'slug' => Str::slug($ticket->title)]);
        $this->dispatchBrowserEvent('open-ticket', ['url' => $url]);
    }
}
