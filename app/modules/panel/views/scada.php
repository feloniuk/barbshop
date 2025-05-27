<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- ApexCharts CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.40.0/apexcharts.min.css" rel="stylesheet">
    <style>
        .dashboard-card {
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            height: 100%;
            transition: all 0.2s ease;
        }
        
        .dashboard-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .card-stat {
            font-size: 1.875rem;
            font-weight: 700;
            margin-top: 0.5rem;
        }
        
        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .icon-red {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        
        .icon-blue {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        
        .chart-container {
            height: 350px;
            width: 100%;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th {
            background-color: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .data-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            color: #4b5563;
        }
        
        .data-table tr:hover td {
            background-color: #f9fafb;
        }
        
        .filter-container {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .filter-label {
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
        }
        
        /* Temp indicator styles */
        .temp-indicator {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        
        .temp-cold {
            background-color: #3b82f6;
        }
        
        .temp-normal {
            background-color: #10b981;
        }
        
        .temp-warm {
            background-color: #f59e0b;
        }
        
        .temp-hot {
            background-color: #ef4444;
        }
        
        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .dashboard-card {
                margin-bottom: 1rem;
            }
        }
    </style>
    
    <div class="container-fluid py-4">

        <!-- KPI Cards -->
        <div class="row mb-4">
            <!-- Current Temperature Card -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                <div class="dashboard-card">
                    <div class="card-icon icon-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"></path>
                        </svg>
                    </div>
                    <div class="card-label">Поточна температура</div>
                    <div class="card-stat" id="current-temp">23.49°C</div>
                </div>
            </div>
            
            <!-- Average Temp Card -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                <div class="dashboard-card">
                    <div class="card-icon icon-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 18h8"></path><path d="M12 18a6 6 0 0 0 0-12v12z"></path>
                        </svg>
                    </div>
                    <div class="card-label">Середня температура</div>
                    <div class="card-stat" id="avg-temp">22.47°C</div>
                </div>
            </div>
            
            <!-- Min Temperature Card -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                <div class="dashboard-card">
                    <div class="card-icon icon-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 15H4"></path><path d="M12 9v12"></path><path d="m5 15 7-6 7 6"></path>
                        </svg>
                    </div>
                    <div class="card-label">Мінімальна температура</div>
                    <div class="card-stat" id="min-temp">17.98°C</div>
                </div>
            </div>
            
            <!-- Max Temperature Card -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                <div class="dashboard-card">
                    <div class="card-icon icon-red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 9H4"></path><path d="M12 15V3"></path><path d="m5 9 7 6 7-6"></path>
                        </svg>
                    </div>
                    <div class="card-label">Максимальна температура</div>
                    <div class="card-stat" id="max-temp">24.35°C</div>
                </div>
            </div>
        </div>

        <!-- Main Chart Section -->
        <div class="row mb-4">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="m-0">Динаміка температури</h4>
                        <div class="d-flex align-items-center">
                        </div>
                    </div>
                    <div id="temperature-chart" class="chart-container"></div>
                </div>
            </div>
        </div>

        <!-- Temperature Data Table -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="m-0">Історія вимірювань температури</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Опис</th>
                                    <th>Температура (°C)</th>
                                    <th>Дата</th>
                                    <th>Час</th>
                                    <th>Статус</th>
                                </tr>
                            </thead>
                            <tbody id="temperature-data">
                                <tr>
                                    <td>2352</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>17.98</td>
                                    <td>15.02.2025</td>
                                    <td>17:15:31</td>
                                    <td><span class="temp-indicator temp-cold"></span> Холодно</td>
                                </tr>
                                <tr>
                                    <td>2353</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>18.76</td>
                                    <td>15.02.2025</td>
                                    <td>17:15:35</td>
                                    <td><span class="temp-indicator temp-normal"></span> Нормально</td>
                                </tr>
                                <tr>
                                    <td>2354</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>19.54</td>
                                    <td>15.02.2025</td>
                                    <td>17:15:40</td>
                                    <td><span class="temp-indicator temp-normal"></span> Нормально</td>
                                </tr>
                                <tr>
                                    <td>2355</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>20.29</td>
                                    <td>15.02.2025</td>
                                    <td>17:15:44</td>
                                    <td><span class="temp-indicator temp-normal"></span> Нормально</td>
                                </tr>
                                <tr>
                                    <td>2356</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>21.01</td>
                                    <td>15.02.2025</td>
                                    <td>17:15:50</td>
                                    <td><span class="temp-indicator temp-normal"></span> Нормально</td>
                                </tr>
                                <tr>
                                    <td>2357</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>21.66</td>
                                    <td>15.02.2025</td>
                                    <td>17:15:55</td>
                                    <td><span class="temp-indicator temp-normal"></span> Нормально</td>
                                </tr>
                                <tr>
                                    <td>2358</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>22.24</td>
                                    <td>15.02.2025</td>
                                    <td>17:16:01</td>
                                    <td><span class="temp-indicator temp-warm"></span> Тепло</td>
                                </tr>
                                <tr>
                                    <td>2359</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>22.77</td>
                                    <td>15.02.2025</td>
                                    <td>17:16:06</td>
                                    <td><span class="temp-indicator temp-warm"></span> Тепло</td>
                                </tr>
                                <tr>
                                    <td>2360</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>23.20</td>
                                    <td>15.02.2025</td>
                                    <td>17:16:13</td>
                                    <td><span class="temp-indicator temp-warm"></span> Тепло</td>
                                </tr>
                                <tr>
                                    <td>2361</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>23.57</td>
                                    <td>15.02.2025</td>
                                    <td>17:16:19</td>
                                    <td><span class="temp-indicator temp-warm"></span> Тепло</td>
                                </tr>
                                <tr>
                                    <td>2367</td>
                                    <td>Температура у приміщенні барбершопу</td>
                                    <td>24.35</td>
                                    <td>15.02.2025</td>
                                    <td>17:17:01</td>
                                    <td><span class="temp-indicator temp-hot"></span> Гаряче</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & ApexCharts JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.40.0/apexcharts.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Temperature data from your database
            const temperatureData = [
                <?php if ($this->scada) foreach ($this->scada as $scada) { ?>
                { id: <?= $scada->ID ?>, temp: <?= $scada->Parameter ?>, date: '<?= $scada->Dates ?>', time: '<?= $scada->Times ?>' },
                <?php } ?>
            ];
            
            // Update KPI values
            updateKPIValues(temperatureData);
            
            // Initialize Temperature Chart
            initTemperatureChart(temperatureData);
            
            // Set up search functionality for the table
            document.getElementById('search-table').addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.getElementById('temperature-data').getElementsByTagName('tr');
                
                Array.from(tableRows).forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
            
            // Set up date filter to reload the page
            document.getElementById('apply-filters').addEventListener('click', function() {
                const date = document.getElementById('date-filter').value;
                const period = document.getElementById('time-period').value;
                
                // In a real application, this would redirect with query parameters
                alert(`Застосовано фільтри: Дата=${date}, Період=${period}`);
            });
        });
        
        function updateKPIValues(data) {
            // Get current temperature (last reading)
            const currentTemp = data[data.length - 1].temp;
            document.getElementById('current-temp').textContent = currentTemp.toFixed(2) + '°C';
            
            // Calculate average temperature
            const sum = data.reduce((acc, item) => acc + item.temp, 0);
            const avg = sum / data.length;
            document.getElementById('avg-temp').textContent = avg.toFixed(2) + '°C';
            
            // Get min temperature
            const min = Math.min(...data.map(item => item.temp));
            document.getElementById('min-temp').textContent = min.toFixed(2) + '°C';
            
            // Get max temperature
            const max = Math.max(...data.map(item => item.temp));
            document.getElementById('max-temp').textContent = max.toFixed(2) + '°C';
        }
        
        function initTemperatureChart(data) {
            const times = data.map(item => item.time);
            const temperatures = data.map(item => item.temp);
            
            // Create color ranges for different temperature zones
            const colorRanges = [];
            temperatures.forEach(temp => {
                if (temp < 18) {
                    colorRanges.push('#3b82f6'); // Cold - blue
                } else if (temp >= 18 && temp < 22) {
                    colorRanges.push('#10b981'); // Normal - green
                } else if (temp >= 22 && temp < 24) {
                    colorRanges.push('#f59e0b'); // Warm - amber
                } else {
                    colorRanges.push('#ef4444'); // Hot - red
                }
            });
            
            const options = {
                series: [{
                    name: 'Температура',
                    data: temperatures
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                colors: ['#ef4444'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                markers: {
                    size: 5,
                    colors: colorRanges,
                    strokeWidth: 0
                },
                xaxis: {
                    categories: times,
                    title: {
                        text: 'Час'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Температура (°C)'
                    },
                    min: Math.floor(Math.min(...temperatures)) - 1,
                    max: Math.ceil(Math.max(...temperatures)) + 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toFixed(2) + '°C';
                        }
                    }
                },
                annotations: {
                    yaxis: [
                        {
                            y: 18,
                            borderColor: '#3b82f6',
                            label: {
                                text: 'Мін. комфортна',
                                style: {
                                    color: '#fff',
                                    background: '#3b82f6'
                                }
                            }
                        },
                        {
                            y: 24,
                            borderColor: '#ef4444',
                            label: {
                                text: 'Макс. комфортна',
                                style: {
                                    color: '#fff',
                                    background: '#ef4444'
                                }
                            }
                        }
                    ]
                }
            };
            
            const chart = new ApexCharts(document.querySelector("#temperature-chart"), options);
            chart.render();
        }
    </script>