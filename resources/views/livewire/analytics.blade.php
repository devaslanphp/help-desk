<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-1">
            <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                @lang('Analytics')
            </span>
            <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                @lang('Below is the dashboard containing all analytics related to projects and tickets configured in :app', [
                    'app' => config('app.name')
                ])
            </span>
        </div>
    </div>
    <div class="w-full flex flex-row flex-wrap">
        <div class="lg:w-1/2 w-full flex flex-col">
            <div class="w-full p-5">
                <div class="w-full flex flex-col gap-5 p-5 rounded-lg border border-gray-100 shadow-lg bg-white">
                    <span class="text-lg text-gray-500 font-medium">@lang('My assigned tickets')</span>
                    <div class="w-full overflow-x-auto relative sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <caption class="hidden">@lang('My assigned tickets')</caption>
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Type')
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Priority')
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Title')
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Status')
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($assignedTickets->count())
                                @foreach($assignedTickets as $ticket)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                                        hover:bg-gray-50 dark:hover:bg-gray-600"
                                    >
                                        <td class="py-4 px-6">
                                            <x-type-span :type="$ticket->type" :min="true"/>
                                        </td>
                                        <td class="py-4 px-6">
                                            <x-priority-span :priority="$ticket->priority"/>
                                        </td>
                                        <td class="py-4 px-6">
                                            <a
                                                href="{{
                                                            route(
                                                                'tickets.details',
                                                                [
                                                                    'ticket' => $ticket,
                                                                    'slug' => Str::slug($ticket->title)
                                                                ]
                                                            )
                                                        }}"
                                                class="text-gray-500 text-sm hover:underline hover:text-primary-500"
                                            >
                                                {{ $ticket->title }}
                                            </a>
                                        </td>
                                        <td class="py-4 px-6">
                                            <x-status-span :status="$ticket->status"/>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                                    hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <td colspan="4" class="py-4 px-6 text-center dark:text-white">
                                        @lang('No assigned tickets yet!')
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="w-full p-5">
                <div
                    class="w-full flex flex-col justify-center items-center gap-5 p-5
                        rounded-lg border border-gray-100 shadow-lg bg-white"
                >
                    <span class="text-lg text-gray-500 font-medium w-full text-left">
                        @lang('Tickets by statuses')
                    </span>
                    <div class="overflow-x-auto relative sm:rounded-lg w-full">
                        <canvas id="ticketsByStatuses" style="height: 200px;"></canvas>
                    </div>
                    <div class="w-full overflow-x-auto relative sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <caption class="hidden">@lang('Tickets by statuses')</caption>
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Status')
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Tickets')
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(sizeof($ticketsByStatuses))
                                @foreach($ticketsByStatuses as $status => $count)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                                        hover:bg-gray-50 dark:hover:bg-gray-600"
                                    >
                                        <td class="py-4 px-6">
                                            {{ $status }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $count }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                                    hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <td colspan="4" class="py-4 px-6 text-center dark:text-white">
                                        @lang('No tickets configured!')
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:w-1/2 w-full flex flex-col">
            <div class="w-full p-5">
                <div
                    class="w-full flex flex-col justify-center items-center
                    gap-5 p-5 rounded-lg border border-gray-100 shadow-lg bg-white"
                >
                    <span class="text-lg text-gray-500 font-medium w-full text-left">
                        @lang('Tickets assignments')
                    </span>
                    <div class="overflow-x-auto relative sm:rounded-lg" style="width: 400px; max-width: 100%;">
                        <canvas id="ticketsAssignments"></canvas>
                    </div>
                    <div class="w-full overflow-x-auto relative sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <caption class="hidden">@lang('Tickets assignments')</caption>
                            <thead
                                class="text-xs text-gray-700 uppercase
                                bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Responsible')
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Assigned tickets')
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(sizeof($ticketsAssignments))
                                @foreach($ticketsAssignments as $responbile => $count)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                                        hover:bg-gray-50 dark:hover:bg-gray-600"
                                    >
                                        <td class="py-4 px-6">
                                            {{ $responbile }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $count }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                                    hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <td colspan="4" class="py-4 px-6 text-center dark:text-white">
                                        @lang('No tickets assigned!')
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="w-full p-5">
                <div class="w-full flex flex-col gap-5 p-5 rounded-lg border border-gray-100 shadow-lg bg-white">
                    <span class="text-lg text-gray-500 font-medium">@lang('Not assigned tickets')</span>
                    <div class="w-full overflow-x-auto relative sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <caption class="hidden">@lang('Not assigned tickets')</caption>
                            <thead
                                class="text-xs text-gray-700 uppercase
                                bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Type')
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Priority')
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Title')
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    @lang('Status')
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($notAssignedTickets->count())
                                @foreach($notAssignedTickets as $ticket)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                                        hover:bg-gray-50 dark:hover:bg-gray-600"
                                    >
                                        <td class="py-4 px-6">
                                            <x-type-span :type="$ticket->type" :min="true"/>
                                        </td>
                                        <td class="py-4 px-6">
                                            <x-priority-span :priority="$ticket->priority"/>
                                        </td>
                                        <td class="py-4 px-6">
                                            <a
                                                href="{{
                                                            route(
                                                                'tickets.details',
                                                                [
                                                                    'ticket' => $ticket,
                                                                    'slug' => Str::slug($ticket->title)
                                                                    ]
                                                                )
                                                     }}"
                                                class="text-gray-500 text-sm hover:underline hover:text-primary-500">
                                                {{ $ticket->title }}
                                            </a>
                                        </td>
                                        <td class="py-4 px-6">
                                            <x-status-span :status="$ticket->status"/>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                                    hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <td colspan="4" class="py-4 px-6 text-center dark:text-white">
                                        @lang('All tickets are assigned!')
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let ctx = document.getElementById('ticketsAssignments').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json(array_keys($ticketsAssignments)),
                datasets: [{
                    label: '@lang('Tickets assignments')',
                    data: @json(array_values($ticketsAssignments)),
                    backgroundColor: [
                        'rgba(240, 82, 82, 0.8)',
                        'rgba(56, 187, 132, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    offset: 10
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        ctx = document.getElementById('ticketsByStatuses').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json(array_keys($ticketsByStatuses)),
                datasets: [{
                    label: '@lang('Tickets assignments')',
                    data: @json(array_values($ticketsByStatuses)),
                    backgroundColor: [
                        'rgba(240, 82, 82, 0.8)',
                        'rgba(56, 187, 132, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    offset: 10
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endpush
