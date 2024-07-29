<div >
    <div>
        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date" wire:model.lazy="startDate">
        <label for="end-date">End Date:</label>
        <input type="date" id="end-date" wire:model.lazy="endDate">
    </div>
        <label id="total-created" data-my-variable="{{ $totalCreated }}">Total Ticket Created: {{$totalCreated}}</label>&emsp;
        <label id="total-closed" data-my-variable="{{ $totalClosed }}">Total Ticket Closed: {{$totalClosed}}</label>&emsp;
        <label id="total-pending" data-my-variable="{{ $totalPending }}">Total Ticket Pending: {{$totalPending}}</label>&emsp;

    <div>
    @foreach(range(1, 12) as $month)
            <button type="button" wire:click="month({{ $month }})"
                class="bg-primary-700 text-white hover:bg-primary-800 px-4 py-1 rounded-lg shadow
                hover:shadow-lg text-base">
                @lang(DateTime::createFromFormat('!m', $month)->format('F'))
            </button>
    @endforeach
    </div>

    <div>
        <input type="checkbox" id="toggle-creation" checked onchange="toggleDataset(0)">
        <label for="toggle-creation">Ticket Creation</label>

        <input type="checkbox" id="toggle-pending" checked onchange="toggleDataset(1)">
        <label for="toggle-pending">Pending Tickets</label>

        <input type="checkbox" id="toggle-closed" checked onchange="toggleDataset(2)">
        <label for="toggle-closed">Closed Tickets</label>
    </div>
    
    <button onclick="generatePDFType('chart')" class="bg-success-600 text-white hover:bg-primary-800 px-4 py-1 rounded-lg shadow
    hover:shadow-lg text-base">Download Chart as PDF</button>
    <button onclick="generatePDF()" class="bg-success-600 text-white hover:bg-primary-800 px-4 py-1 rounded-lg shadow
    hover:shadow-lg text-base">Download Chart and Table as PDF</button>
    <canvas id="trendChart" width="400" height="150"></canvas>

    <button onclick="generatePDFType('table')" class="bg-success-600 text-white hover:bg-primary-800 px-4 py-1 rounded-lg shadow
    hover:shadow-lg text-base">Download Table as PDF</button>
    <table id="ticketTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400" style="width: 100%; border-collapse: collapse; text-align: center;">
        <thead class="text-xs text-gray-700 uppercase
        bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
            <th style="border: 1px solid black; padding: 5px; text-align: center;" scope="col" class="py-3 px-6">Date</th>
            <th style="border: 1px solid black; padding: 5px; text-align: center;" scope="col" class="py-3 px-6">Ticket Creation</th>
            <th style="border: 1px solid black; padding: 5px; text-align: center;" scope="col" class="py-3 px-6">Pending Tickets</th>
            <th style="border: 1px solid black; padding: 5px; text-align: center;" scope="col" class="py-3 px-6">Closed Tickets</th>
            </tr>
        </thead>
        <tbody>
            @foreach($labels as $index => $label)
                <tr>
                    <td style="border: 1px solid black; padding: 5px; height: 20px; vertical-align: middle; text-align: center;">{{ $label }}</td>
                    <td style="border: 1px solid black; padding: 5px; height: 20px; vertical-align: middle; text-align: center;">{{ $ticketCreationData[$index] }}</td>
                    <td style="border: 1px solid black; padding: 5px; height: 20px; vertical-align: middle; text-align: center;">{{ $pendingTicketData[$index] }}</td>
                    <td style="border: 1px solid black; padding: 5px; height: 20px; vertical-align: middle; text-align: center;">{{ $closedTicketData[$index] }}</td>
                </tr>
            @endforeach
                <tr>
                    <td style="color: white">a</td>
                    <td style="color: white">a</td>
                    <td style="color: white">a</td>
                    <td style="color: white">a</td>
                </tr>
        </tbody>
    </table>


    <script>
        document.addEventListener('livewire:load', function () {
            let trendChart = null;

            function renderChartTrend(labels, ticketCreationData, pendingTicketData, closedTicketData) {
                const ctxTrend = document.getElementById('trendChart').getContext('2d');
                if (trendChart) {
                    trendChart.destroy();
                }
                
                trendChart = new Chart(ctxTrend, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Ticket Creation',
                                data: ticketCreationData,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: false
                            },
                            {
                                type: 'bar',
                                label: 'Pending Tickets',
                                data: pendingTicketData,
                                borderColor: 'rgba(255, 159, 64, 1)',
                                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                fill: true
                            },
                            {
                                label: 'Closed Tickets',
                                data: closedTicketData,
                                borderColor: 'rgba(153, 102, 255, 1)',
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Ticket Trends Over Time'
                        },
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day'
                                },
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                max:5,
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Number of Tickets'
                                },
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
            
            function toggleDataset(index) {
                const chart = trendChart;
                const meta = chart.getDatasetMeta(index);
                meta.hidden = meta.hidden === null ? !chart.data.datasets[index].hidden : null;
                chart.update();
            }

            // Initial rendering
            renderChartTrend(@json($labels), @json($ticketCreationData), @json($pendingTicketData), @json($closedTicketData));

            // Re-rendering when Livewire updates
            Livewire.hook('message.processed', (message, component) => {
                
                if (component.fingerprint.name === 'analytics.ticket-trend') {
                const labels = component.get('labels') || [];
                const ticketCreationData = component.get('ticketCreationData') || [];
                const pendingTicketData = component.get('pendingTicketData') || [];
                const closedTicketData = component.get('closedTicketData') || [];
                

                trendChart.data.labels = labels;
                trendChart.data.datasets[0].data = ticketCreationData;
                trendChart.data.datasets[1].data = pendingTicketData;
                trendChart.data.datasets[2].data = closedTicketData;
                trendChart.update();
                }
            });

            // Make toggleDataset globally accessible
            window.toggleDataset = toggleDataset;
            
        });

        function generatePDFType(type) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            if (type === 'chart') {
                html2canvas(document.querySelector("#trendChart")).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgWidth = 190;
                    const pageHeight = 295;
                    const imgHeight = canvas.height * imgWidth / canvas.width;
                    let heightLeft = imgHeight;

                    let position = 10;

                    doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;

                    while (heightLeft >= 0) {
                        position = heightLeft - imgHeight;
                        doc.addPage();
                        doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                        heightLeft -= pageHeight;
                    }

                    doc.save('chart.pdf');
                });
            } else if (type === 'table') {
                html2canvas(document.querySelector("#ticketTable")).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgWidth = 190;
                    const pageHeight = 295;
                    const imgHeight = canvas.height * imgWidth / canvas.width;
                    let heightLeft = imgHeight;

                    let position = 10;

                    doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;

                    while (heightLeft >= 0) {
                        position = heightLeft - imgHeight;
                        doc.addPage();
                        doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                        heightLeft -= pageHeight;
                    }

                    doc.save('table.pdf');
                });
            }
        }

        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Get the selected date range
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;

            // Format the date range for the PDF header
            const formattedStartDate = new Date(startDate).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            const formattedEndDate = new Date(endDate).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            let customText;
            if (formattedStartDate === formattedEndDate) {
                customText = `Report for ${formattedStartDate}`; // Customize your header text here
            } else {
                customText = `Report for ${formattedStartDate} to ${formattedEndDate}`; // Customize your header text here
            }
            
            // Add customized header
            const pageWidth = doc.internal.pageSize.getWidth();
            const textWidth = doc.getTextWidth(customText);
            const textX = (pageWidth - textWidth) / 2;

            doc.setFontSize(18);
            doc.text(customText, textX, 10);

            // Get totals from Livewire component
            let createdElement = document.getElementById('total-created');
            let totalCreated = createdElement.getAttribute('data-my-variable');
            let closedElement = document.getElementById('total-closed');
            let totalClosed = closedElement.getAttribute('data-my-variable');
            let pendingElement = document.getElementById('total-pending');
            let totalPending = pendingElement.getAttribute('data-my-variable');

            // Define the height available for each element
            const chartHeight = 80;
            const tableHeight = 80;
            const margin = 10;

            // Capture and add chart
            html2canvas(document.querySelector("#trendChart"), { scale: 2 }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = pageWidth - 2 * margin;
                const imgHeight = canvas.height * imgWidth / canvas.width;
                doc.addImage(imgData, 'PNG', margin, 45, imgWidth, chartHeight);

                // Add customized label for chart
                // const chartLabelWidth = doc.getTextWidth("Figure: Ticket Volume Over Time");
                // const chartLabelX = (pageWidth - chartLabelWidth) / 2;
                // doc.setFontSize(12);
                // doc.text("Figure: Ticket Volume Over Time", chartLabelX, imgHeight + 25);

                // Capture and add table
                html2canvas(document.querySelector("#ticketTable"), { scale: 2 }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgWidth = pageWidth - 2 * margin;
                    const imgHeight = canvas.height * imgWidth / canvas.width;
                    doc.addImage(imgData, 'PNG', margin, 40 + chartHeight + margin, imgWidth, tableHeight + 30);

                    // Add another customized label for table
                    // const tableLabelWidth = doc.getTextWidth("Table: Ticket Volume Over Time");
                    // const tableLabelX = (pageWidth - tableLabelWidth) / 2;
                    // doc.setFontSize(12);
                    // doc.text("Table: Ticket Volume Over Time", tableLabelX, imgHeight + 20);
                    
                    // Add totals to PDF
                    doc.setFontSize(14);
                    doc.text(`Total Tickets Created : ${totalCreated}`, 10, 20);
                    doc.text(`Total Tickets Closed : ${totalClosed}`, 10, 30);
                    doc.text(`Total Pending Tickets at the end of month: ${totalPending}`, 10, 40);
                    
                    // Save the PDF
                    doc.save('report.pdf');
                });
            });
        }
    </script>
</div>