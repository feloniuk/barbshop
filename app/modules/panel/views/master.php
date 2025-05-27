<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="<?= _SITEDIR_ ?>public/css/modules-widgets.css" rel="stylesheet" type="text/css">
<link href="<?= _SITEDIR_ ?>public/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css">

<style>
    /* Custom styles for appointments */
    .fc-event {
        border: none !important;
        border-radius: 4px !important;
        padding: 5px !important;
    }
    
    .fc-event.new {
        background-color: #f59e0b !important;
        border-left: 4px solid #d97706 !important;
    }
    
    .fc-event.completed {
        background-color: #3b82f6 !important;
        border-left: 4px solid #2563eb !important;
    }
    
    .fc-event.cancelled {
        background-color: #ef4444 !important;
        border-left: 4px solid #dc2626 !important;
    }
    
    .fc-day-grid-event .fc-content {
        color:rgb(0, 0, 0);
        white-space: normal !important;
        cursor: pointer;
    }

    .fc-time-grid-event {
        
        color:rgb(0, 0, 0) !important;
    }

    
    .fc-today {
        background-color: rgba(245, 158, 11, 0.1) !important;
    }
    
    /* Custom styles for cards */
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
    
    .icon-yellow {
        background-color: rgba(245, 158, 11, 0.1);
    }
    
    .icon-blue {
        background-color: rgba(59, 130, 246, 0.1);
    }
    
    .icon-green {
        background-color: rgba(16, 185, 129, 0.1);
    }
    
    .icon-purple {
        background-color: rgba(139, 92, 246, 0.1);
    }
    
    /* Custom styles for appointment details */
    .appointment-details {
        position: absolute;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 1rem;
        width: 320px;
        z-index: 1000;
        display: none;
    }
    
    .details-section {
        margin-bottom: 1rem;
    }
    
    .details-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .details-value {
        color: #4b5563;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        color: white;
    }
    
    .status-new {
        background-color: #f59e0b;
    }
    
    .status-conflict {
        background-color: #e7515a;
    }
    .status-done {
        background-color:rgb(36, 97, 21);
    }
    
    .conflict {
        background-color: #e7515a;
    }
    
    /* Responsive spacing */
    @media (max-width: 768px) {
        .dashboard-card {
            margin-bottom: 1rem;
        }
    }
    .appointment-close {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    cursor: pointer;
    color: #888;
    transition: color 0.2s ease;
}

.appointment-close:hover {
    color: #333;
}

.appointment-close svg {
    width: 100%;
    height: 100%;
}
</style>

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <!-- Stats Cards Row -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="row">
                <!-- Today's Appointments Card -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="dashboard-card">
                        <div class="card-icon icon-yellow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        </div>
                        <div class="card-label">Сегодняшние записи</div>
                        <div class="card-stat" id="today-appointments">
                            <?php
                            $today = (new DateTime())->format('d.m.Y');
                            $todayCount = 0;
                            
                            foreach ($this->orders as $order) {
                                if ($order->selectedDate === $today) {
                                    $todayCount++;
                                }
                            }
                            
                            echo $todayCount;
                            ?>
                        </div>
                    </div>
                </div>
                
                <!-- Total Clients Card -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="dashboard-card">
                        <div class="card-icon icon-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <div class="card-label">Всего клиентов</div>
                        <div class="card-stat" id="total-clients">
                            <?php
                            $clients = [];
                            foreach ($this->orders as $order) {
                                if ($order->name && !in_array($order->name, $clients)) {
                                    $clients[] = $order->name;
                                }
                            }
                            echo count($clients);
                            ?>
                        </div>
                    </div>
                </div>
                
                <!-- Revenue Card -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="dashboard-card">
                        <div class="card-icon icon-green">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        </div>
                        <div class="card-label">Общий доход</div>
                        <div class="card-stat" id="total-revenue">
                            <?php
                            $totalRevenue = 0;
                            
                            foreach ($this->orders as $order) {
                                if ($order->status === 'completed') {
                                    $totalRevenue += $order->service->price;
                                }
                            }
                            
                            echo $totalRevenue . ' грн';
                            ?>
                        </div>
                    </div>
                </div>
                
                <!-- Popular Service Card -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="dashboard-card">
                        <div class="card-icon icon-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        </div>
                        <div class="card-label">Популярная услуга</div>
                        <div id="popular-service" style="font-size: 1.25rem; font-weight: 600; margin-top: 0.5rem;">
                            <?php
                            $serviceCount = [];
                            
                            foreach ($this->orders as $order) {
                                $serviceTitle = $order->service->title;
                                
                                if (!isset($serviceCount[$serviceTitle])) {
                                    $serviceCount[$serviceTitle] = 0;
                                }
                                
                                $serviceCount[$serviceTitle]++;
                            }
                            
                            arsort($serviceCount);
                            echo key($serviceCount);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar View -->
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <div class="row">
                        <div class="col-6">
                            <h4>Календарь записей</h4>
                        </div>
                        <div class="col-6 text-right">
                            <select id="service-filter" class="form-control" style="display: inline-block; width: auto;">
                                <option value="all">Все услуги</option>
                                <?php
                                $services = [];
                                foreach ($this->orders as $order) {
                                    if (!in_array($order->service->title, $services)) {
                                        $services[] = $order->service->title;
                                        echo '<option value="' . $order->service_id . '">' . $order->service->title . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="widget-content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4>Статистика дохода</h4>
                </div>
                <div class="widget-content">
                    <div id="revenue-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Details Modal -->
<div id="appointment-details" class="appointment-details">
    <div class="appointment-close" id="close-appointment-details">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </div>

    <div class="details-section">
        <div class="details-title">Услуга</div>
        <div id="service-name" class="details-value"></div>
    </div>
    <div class="details-section">
        <div class="details-title">Клиент</div>
        <div id="client-name" class="details-value"></div>
    </div>
    <div class="details-section">
        <div class="details-title">Телефон</div>
        <div id="client-phone" class="details-value"></div>
    </div>
    <div class="details-section">
        <div class="details-title">Дата и время</div>
        <div id="appointment-time" class="details-value"></div>
    </div>
    <div class="details-section">
        <div class="details-title">Стоимость</div>
        <div id="service-price" class="details-value"></div>
    </div>
    <div class="details-section">
        <div class="details-title">Статус</div>
        <div id="status-badge"></div>
    </div>
    <div class="details-section">
        <button id="complete-btn" class="btn btn-sm btn-success">Выполнено</button>
        <button id="cancel-btn" class="btn btn-sm btn-danger">Отменить</button>
    </div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="<?= _SITEDIR_ ?>public/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?= _SITEDIR_ ?>public/plugins/apex/apexcharts.min.js"></script>

<script>
    $(function() {
        // Store all appointments data
        var appointments = [];
        var incomeData = {};
        var currentSelectedService = 'all';
        var currentActiveAppointment = null;
        
        <?php
        // Prepare appointments data
        foreach ($this->orders as $order) {
            // Convert date format from DD.MM.YYYY to YYYY-MM-DD for calendar
            $dateParts = explode('.', $order->selectedDate);
            if (count($dateParts) == 3) {
                $calendarDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
                
                // Track income data for the chart
                $month = $dateParts[1] . '/' . $dateParts[2]; // MM/YYYY format
                
                if (!isset($incomeData[$month])) {
                    $incomeData[$month] = 0;
                }
                
                if ($order->status === 'done') {
                    $incomeData[$month] += $order->service->price;
                }
                
                $status = isset($order->status) ? $order->status : 'new';
                
                // Status text in Ukrainian
                $statusText = 'Новая';
                if ($status === 'done') {
                    $statusText = 'Выполнено';
                } else if ($status === 'new') {
                    $statusText = 'Новая';
                } else if ($status === 'conflict') {
                    $statusText = 'Отменено';
                }
                
                echo "
                appointments.push({
                    id: " . $order->id . ",
                    title: '" . addslashes($order->service->title) . "',
                    start: '" . $calendarDate . "T" . $order->selectedTime . ":00',
                    className: '" . $status . "',
                    serviceId: " . $order->service_id . ",
                    clientName: '" . addslashes($order->name ?: 'Не указано') . "',
                    clientPhone: '" . addslashes($order->tel ?: 'Не указано') . "',
                    price: " . $order->service->price . ",
                    status: '" . $status . "',
                    statusText: '" . $statusText . "'
                });
                ";
            }
        }
        
        // Prepare income data for chart
        echo "var incomeChartData = [";
        
        foreach ($incomeData as $month => $amount) {
            echo "{ x: '" . $month . "', y: " . $amount . " },";
        }
        
        echo "];";
        ?>
        
        // Initialize FullCalendar
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'month',
            navLinks: true,
            editable: false,
            eventLimit: true,
            events: appointments,
            timeFormat: 'H:mm',              // 24-hour format without the 'h' notation
            axisFormat: 'H:mm',              // 24-hour format for the axis (side) labels
            slotLabelFormat: 'H:mm',         // 24-hour format for slot labels
            scrollTime: '08:00:00',          // Default scroll time (will be overridden)
            minTime: '08:00:00',             // Start the day view at 8 AM
            maxTime: '00:00:00',             // End the day view at 12 PM
            eventRender: function(event, element) {
                // Filter based on selected service
                if (currentSelectedService !== 'all' && event.serviceId != currentSelectedService) {
                    return false;
                }
            },
            eventClick: function(event, jsEvent, view) {
                showAppointmentDetails(event, jsEvent);
            }
            
        });
        
        // Initialize Revenue Chart
        var revenueChart = new ApexCharts(document.querySelector("#revenue-chart"), {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    distributed: false,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            colors: ['#f59e0b'],
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val + ' грн';
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            series: [{
                name: 'Доход',
                data: incomeChartData
            }],
            xaxis: {
                type: 'category',
                labels: {
                    rotate: -45,
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Доход (грн)'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " грн";
                    }
                }
            }
        });
        
        revenueChart.render();
        
        // Service filter handling
        $('#service-filter').on('change', function() {
            currentSelectedService = $(this).val();
            $('#calendar').fullCalendar('rerenderEvents');
        });
        
        function showAppointmentDetails(appointment, jsEvent) {
    currentActiveAppointment = appointment;
    
    // Populate details
    $('#service-name').text(appointment.title);
    $('#client-name').text(appointment.clientName);
    $('#client-phone').text(appointment.clientPhone);
    $('#appointment-time').text(moment(appointment.start).format('DD.MM.YYYY HH:mm'));
    $('#service-price').text(appointment.price + ' грн');
    
    // Set status badge
    var statusBadge = '<span class="status-badge status-' + appointment.status + '">' + appointment.statusText + '</span>';
    $('#status-badge').html(statusBadge);
    
    // Update buttons
    $('#complete-btn').data('id', appointment.id);
    $('#cancel-btn').data('id', appointment.id);
    
    // Position and show the details
    var details = $('#appointment-details');
    
    // Get window dimensions
    var windowWidth = $(window).width();
    var windowHeight = $(window).height();
    
    // Get popup dimensions
    var popupWidth = details.outerWidth();
    var popupHeight = details.outerHeight();
    
    // Calculate initial position
    var top = jsEvent.pageY - 100;
    var left = jsEvent.pageX - 220;
    
    // Adjust position if needed to keep within screen
    if (left < 10) {
        left = 10;
    } else if (left + popupWidth > windowWidth - 10) {
        left = windowWidth - popupWidth - 10;
    }
    
    if (top < 10) {
        top = 10;
    } else if (top + popupHeight > windowHeight - 10) {
        top = windowHeight - popupHeight - 10;
    }
    
    // Apply position and show
    details.css({
        top: top,
        left: left
    }).show();
    
    // Handle clicking outside to close
    $(document).one('click', function(e) {
        if (!$(e.target).closest('#appointment-details, .fc-event').length) {
            details.hide();
        }
    });
    
    // Prevent clicks inside from closing
    details.click(function(e) {
        e.stopPropagation();
    });
}
        
        // Handle appointment status update
        function updateAppointmentStatus(id, status) {
            $.ajax({
                url: '<?= _SITEDIR_ ?>panel/appointments/update-status/' + id,
                type: 'POST',
                data: { status: status },
                success: function(response) {
                    if (response.success) {
                        // Reload the page or update the view
                        location.reload();
                    } else {
                        alert('Ошибка: ' + (response.message || 'Неизвестная ошибка'));
                    }
                },
                error: function() {
                    alert('Произошла ошибка при обновлении статуса');
                }
            });
        }
        
        // Button handlers
        $('#complete-btn').on('click', function() {
            var id = $(this).data('id');
            load('panel/orders/change_status/' + id, 'status=done')
        });
        
        $('#cancel-btn').on('click', function() {
            var id = $(this).data('id');
            if (confirm('Вы уверены, что хотите отменить запись?')) {
                load('panel/orders/change_status/' + id, 'status=conflict')
            }
        });

        // Add this to your JavaScript in the $(function() { ... }) block
        $('#close-appointment-details').on('click', function() {
            $('#appointment-details').hide();
        });
    });
</script>