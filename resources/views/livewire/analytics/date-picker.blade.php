<div>
    <div class="flex space-x-4">
        <div>
            <label for="startDate">Start Date</label>
            <input type="date" id="startDate" wire:model="startDate" class="border rounded p-2">
        </div>
        <div>
            <label for="endDate">End Date</label>
            <input type="date" id="endDate" wire:model="endDate" class="border rounded p-2">
        </div>
    </div>

    <div class="mt-4">
        <h2 class="text-xl font-semibold">Ticket Analytics</h2>
        
        <canvas id="ticketChart" class="mt-4"></canvas>
    </div>
    
    <script>
        document.addEventListener('livewire:load', function () {
            const ctx = document.getElementById('ticketChart').getContext('2d');
            let ticketChart;

            function renderChart(data) {
                if (ticketChart) {
                    ticketChart.destroy();
                }
            
                ticketChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(item => item.date),
                        datasets: [{
                            label: 'Tickets',
                            data: data.map(item => item.count),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        if (Number.isInteger(value)) {
                                            return value;
                                        }
                                    }   
                                }
                            }
                        }
                    }
                });

            }
            
                window.livewire.on('chartDataUpdated', data => {
                renderChart(data);
            });

            renderChart(@json($chartData));
        });

        window.livewire.hook('message.processed', (message, component) => {
            if (message.updateQueue[0].payload.name === 'ticketsData') {
                window.livewire.emit('chartDataUpdated', @json($chartData));
            }
        });
    </script>
</div>