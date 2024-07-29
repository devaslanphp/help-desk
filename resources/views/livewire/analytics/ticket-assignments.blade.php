<div>
    <div class="w-full p-5">
        <div class="w-full flex flex-col justify-center items-center gap-5 p-5 rounded-lg border border-gray-100 shadow-lg bg-white">
            <span class="text-lg text-gray-500 font-medium w-full text-left">
                @lang('Tickets assignments')
            </span>
            <div>
                <label for="start-date-assignment">Start Date:</label>
                <input type="date" id="start-date-assignment" wire:model.lazy="startDateAssignment">
                <label for="end-date-assignment">End Date:</label>
                <input type="date" id="end-date-assignment" wire:model.lazy="endDateAssignment">
            </div>
            <div class="overflow-x-auto relative sm:rounded-lg" style="width: 300px; max-width: 100%;">
                <canvas id="assignmentChart"></canvas>
            </div>
            <div class="w-full overflow-x-auto relative sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <caption class="hidden">@lang('Tickets assignments')</caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                        @foreach($ticketsAssignments as $responsible => $count)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-4 px-6">
                                {{ $responsible }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $count }}
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="2" class="py-4 px-6 text-center dark:text-white">
                                @lang('No tickets assigned!')
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
       document.addEventListener('livewire:load', function () {
    let assignmentChart = null;

    Livewire.on('updateChart', (labels, data) => {
        updateChart(labels, data);
    });

    Livewire.hook('message.processed', (message, component) => {
        if (component.fingerprint.name === 'tickets-assignments') {
            const labels = @json($labelAssignment);
            const data = @json($dataAssignment);
            updateChart(labels, data);
        }
    });

    function updateChart(labels, data) {
        if (!labels || !data) {
            console.error('Labels or data is empty');
            return;
        }

        const canvas = document.getElementById('assignmentChart');

        if (!canvas) {
            console.error('Canvas element not found');
            return;
        }

        const ctx = canvas.getContext('2d');

        if (assignmentChart) {
            assignmentChart.destroy();
        }

        assignmentChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: '@lang('Assigned tickets')',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
            ],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Initial rendering
    updateChart(@json($labelAssignment), @json($dataAssignment));
        });
    </script>
    @endpush
</div>