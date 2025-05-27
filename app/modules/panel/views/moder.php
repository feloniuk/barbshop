<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="<?= _SITEDIR_ ?>public/css/modules-widgets.css" rel="stylesheet" type="text/css">
<link href="<?= _SITEDIR_ ?>public/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css">

<style>
    /* Custom styles for dashboard elements */
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
    
    .icon-red {
        background-color: rgba(239, 68, 68, 0.1);
    }
    
    /* Chart containers */
    .chart-container {
        height: 350px;
        width: 100%;
    }
    
    /* Custom styles for calendar */
    .fc-event {
        border: none !important;
        border-radius: 4px !important;
        padding: 5px !important;
    }
    
    .fc-event.new {
        background-color: #f59e0b !important;
        border-left: 4px solid #d97706 !important;
    }
    
    .fc-event.done {
        background-color: #10b981 !important;
        border-left: 4px solid #059669 !important;
    }
    
    .fc-event.conflict {
        background-color: #ef4444 !important;
        border-left: 4px solid #dc2626 !important;
    }
    
    .fc-day-grid-event .fc-content,
    .fc-time-grid-event .fc-content {
        color: #ffffff;
        white-space: normal !important;
        cursor: pointer;
    }
    
    .fc-time-grid-event .fc-time,
    .fc-time-grid-event .fc-title {
        color: #ffffff !important;
    }
    
    /* Fix for calendar views */
    .fc-day-grid-event .fc-content {
        max-height: none !important;
        overflow: visible !important;
    }
    
    /* Make sure time-grid events display correctly */
    .fc-time-grid-event {
        min-height: 20px;
    }
    
    .fc-today {
        background-color: rgba(245, 158, 11, 0.1) !important;
    }
    
    /* Table styling */
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
    
    /* Status badges */
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
    
    .status-done {
        background-color: #10b981;
    }
    
    .status-conflict {
        background-color: #ef4444;
    }
    
    /* Filter and selection styles */
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
    
    .date-range-picker {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    
    /* Avatar styling */
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }
    
    .master-info {
        display: flex;
        align-items: center;
    }
    
    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 5px;
        flex-direction: column;
    }
    
    .action-buttons .btn {
        padding: 3px 8px;
        font-size: 0.75rem;
        white-space: nowrap;
    }
    
    /* Status transition animation */
    @keyframes statusChange {
        0% { opacity: 0.5; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
    
    .status-changing {
        animation: statusChange 0.5s ease;
    }
    
    /* Appointment details */
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
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .filter-container {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .date-range-picker {
            width: 100%;
        }
        
        .dashboard-card {
            margin-bottom: 1rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="layout-px-spacing">
    <!-- Page header and filters -->
    <div class="row layout-top-spacing">
        <div class="col-12">
            <div class="page-header">
                <h2>Аналитика барбершопа</h2>
                <div class="filter-container">
                    <div>
                        <span class="filter-label">Период:</span>
                        <div class="date-range-picker">
                            <input type="date" id="date-from" name="date_from" class="form-control" value="<?= get('date_from') ?: date('Y-m-01') ?>">
                            <span>—</span>
                            <input type="date" id="date-to" name="date_to" class="form-control" value="<?= get('date_to') ?: date('Y-m-t') ?>">
                        </div>
                    </div>
                    
                    <div>
                        <span class="filter-label">Барбершоп:</span>
                        <select id="shop-filter" class="form-control">
                            <option value="all">Все барбершопы</option>
                            <?php foreach ($this->user->shops as $shop): ?>
                                <option value="<?= $shop->id ?>" <?= get('shop_id') === $shop->id ? 'selected': '' ?>><?= $shop->title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <span class="filter-label">Мастер:</span>
                        <select id="master-filter" class="form-control">
                            <option value="all">Все мастера</option>
                            <?php foreach ($this->users_list as $master): ?>
                                <option value="<?= $master->id ?>" <?= get('master_id') === $master->id ? 'selected': '' ?>><?= $master->firstname . ' ' . $master->lastname ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button id="apply-filters" class="btn btn-primary">Применить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row layout-spacing">
        <!-- Total Revenue Card -->
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
                        if ($order->status === 'done') {
                            $totalRevenue += $order->service->price;
                        }
                    }
                    
                    echo $totalRevenue . ' грн';
                    ?>
                </div>
            </div>
        </div>
        
        <!-- Total Completed Appointments -->
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
            <div class="dashboard-card">
                <div class="card-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <div class="card-label">Выполненные записи</div>
                <div class="card-stat" id="completed-appointments">
                    <?php
                    $completedCount = 0;
                    
                    foreach ($this->orders as $order) {
                        if ($order->status === 'done') {
                            $completedCount++;
                        }
                    }
                    
                    echo $completedCount;
                    ?>
                </div>
            </div>
        </div>
        
        <!-- Total Clients Card -->
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
            <div class="dashboard-card">
                <div class="card-icon icon-yellow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <div class="card-label">Всего клиентов</div>
                <div class="card-stat" id="unique-clients">
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
        
        <!-- Cancellation Rate -->
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
            <div class="dashboard-card">
                <div class="card-icon icon-red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                </div>
                <div class="card-label">Процент отмен</div>
                <div class="card-stat" id="cancellation-rate">
                    <?php
                    $totalAppointments = count($this->orders);
                    $cancelledCount = 0;
                    
                    foreach ($this->orders as $order) {
                        if ($order->status === 'conflict') {
                            $cancelledCount++;
                        }
                    }
                    
                    $cancellationRate = $totalAppointments > 0 ? 
                        round(($cancelledCount / $totalAppointments) * 100, 1) : 0;
                    
                    echo $cancellationRate . '%';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Section -->
    <div class="row layout-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
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
                                        $services[$order->service_id] = $order->service->title;
                                        echo '<option value="' . $order->service_id . '">' . $order->service->title . '</option>';
                                    
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="widget-content">
                    <div id="appointments-calendar"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Appointments -->
    <div class="row layout-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h4>Последние записи</h4>
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Дата и время</th>
                                    <th>Клиент</th>
                                    <th>Услуга</th>
                                    <th>Мастер</th>
                                    <th>Барбершоп</th>
                                    <th>Стоимость</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody id="recent-appointments-table">
                                <?php
                                // Sort orders by date (newest first)
                                $recentOrders = $this->orders;
                                usort($recentOrders, function($a, $b) {
                                    return $b->time - $a->time;
                                });
                                
                                // Get first 10 orders
                                $recentOrders = array_slice($recentOrders, 0, 10);
                                
                                foreach ($recentOrders as $order) {
                                    // Get master name
                                    $masterName = '';
                                    foreach ($this->users_list as $master) {
                                        if ($master->id == $order->user_id) {
                                            $masterName = $master->firstname . ' ' . $master->lastname;
                                            break;
                                        }
                                    }
                                    
                                    // Get shop name
                                    $shopName = '';
                                    foreach ($this->users_list as $master) {
                                        foreach ($master->shops as $shop) {
                                            if ($shop->id == $order->shop_id) {
                                                $shopName = $shop->title;
                                                break 2;
                                            }
                                        }
                                    }
                                    
                                    // Status text
                                    $statusText = '';
                                    $statusClass = '';
                                    switch ($order->status) {
                                        case 'new':
                                            $statusText = 'Новая';
                                            $statusClass = 'status-new';
                                            break;
                                        case 'done':
                                            $statusText = 'Выполнено';
                                            $statusClass = 'status-done';
                                            break;
                                        case 'conflict':
                                            $statusText = 'Отменено';
                                            $statusClass = 'status-conflict';
                                            break;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $order->selectedDate ?> <?= $order->selectedTime ?></td>
                                        <td><?= $order->name ?: 'Не указано' ?></td>
                                        <td><?= $order->service->title ?></td>
                                        <td><?= $masterName ?></td>
                                        <td><?= $shopName ?></td>
                                        <td><?= $order->service->price ?> грн</td>
                                        <td><span class="status-badge <?= $statusClass ?>" id="status-badge-<?= $order->id ?>"><?= $statusText ?></span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <?php if ($order->status !== 'done'): ?>
                                                    <button class="btn btn-sm btn-success complete-btn" data-id="<?= $order->id ?>" onclick="changeOrderStatus(<?= $order->id ?>, 'done')">
                                                        Выполнено
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <?php if ($order->status !== 'conflict'): ?>
                                                    <button class="btn btn-sm btn-danger cancel-btn" data-id="<?= $order->id ?>" onclick="changeOrderStatus(<?= $order->id ?>, 'conflict', true)">
                                                        Отменить
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <?php if ($order->status !== 'new'): ?>
                                                    <button class="btn btn-sm btn-warning reset-btn" data-id="<?= $order->id ?>" onclick="changeOrderStatus(<?= $order->id ?>, 'new')">
                                                        Сбросить
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row layout-spacing">
        <!-- Revenue Trend Chart -->
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4>Динамика дохода</h4>
                </div>
                <div class="widget-content">
                    <div id="revenue-trend-chart" class="chart-container"></div>
                </div>
            </div>
        </div>
        
        <!-- Service Popularity Chart -->
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <h4>Популярность услуг</h4>
                </div>
                <div class="widget-content">
                    <div id="service-popularity-chart" class="chart-container"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Master Performance and Shop Performance -->
    <div class="row layout-spacing">
        <!-- Master Performance -->
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h4>Эффективность мастеров</h4>
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Мастер</th>
                                    <th>Выполненные записи</th>
                                    <th>Доход</th>
                                    <th>Отмены</th>
                                </tr>
                            </thead>
                            <tbody id="master-performance-table">
                                <?php
                                $masterStats = [];
                                
                                // Gather statistics for each master
                                foreach ($this->orders as $order) {
                                    $masterId = $order->user_id;
                                    
                                    if (!isset($masterStats[$masterId])) {
                                        $masterStats[$masterId] = [
                                            'completed' => 0,
                                            'revenue' => 0,
                                            'cancelled' => 0
                                        ];
                                    }
                                    
                                    if ($order->status === 'done') {
                                        $masterStats[$masterId]['completed']++;
                                        $masterStats[$masterId]['revenue'] += $order->service->price;
                                    } elseif ($order->status === 'conflict') {
                                        $masterStats[$masterId]['cancelled']++;
                                    }
                                }
                                
                                // Display data for each master
                                foreach ($this->users_list as $master) {
                                    $masterId = $master->id;
                                    $stats = isset($masterStats[$masterId]) ? $masterStats[$masterId] : ['completed' => 0, 'revenue' => 0, 'cancelled' => 0];
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="master-info">
                                                <?php if (!empty($master->image)): ?>
                                                    <img src="<?= _SITEDIR_ . Storage::shardDir('users', $master->id) . $master->image ?>" alt="<?= $master->firstname ?>" class="avatar">
                                                <?php endif; ?>
                                                <span><?= $master->firstname . ' ' . $master->lastname ?></span>
                                            </div>
                                        </td>
                                        <td><?= $stats['completed'] ?></td>
                                        <td><?= $stats['revenue'] ?> грн</td>
                                        <td><?= $stats['cancelled'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Shop Performance -->
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h4>Эффективность барбершопов</h4>
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Барбершоп</th>
                                    <th>Выполненные записи</th>
                                    <th>Доход</th>
                                    <th>Отмены</th>
                                </tr>
                            </thead>
                            <tbody id="shop-performance-table">
                                <?php
                                $shopStats = [];
                                
                                // Gather statistics for each shop
                                foreach ($this->orders as $order) {
                                    $shopId = $order->shop_id;
                                    
                                    if (!isset($shopStats[$shopId])) {
                                        $shopStats[$shopId] = [
                                            'completed' => 0,
                                            'revenue' => 0,
                                            'cancelled' => 0
                                        ];
                                    }
                                    
                                    if ($order->status === 'done') {
                                        $shopStats[$shopId]['completed']++;
                                        $shopStats[$shopId]['revenue'] += $order->service->price;
                                    } elseif ($order->status === 'conflict') {
                                        $shopStats[$shopId]['cancelled']++;
                                    }
                                }
                                
                                // Get all unique shops
                                $shops = [];
                                foreach ($this->users_list as $master) {
                                    foreach ($master->shops as $shop) {
                                        $shops[$shop->id] = $shop;
                                    }
                                }
                                
                                // Display data for each shop
                                foreach ($shops as $shopId => $shop) {
                                    $stats = isset($shopStats[$shopId]) ? $shopStats[$shopId] : ['completed' => 0, 'revenue' => 0, 'cancelled' => 0];
                                    ?>
                                    <tr>
                                        <td><?= $shop->title ?></td>
                                        <td><?= $stats['completed'] ?></td>
                                        <td><?= $stats['revenue'] ?> грн</td>
                                        <td><?= $stats['cancelled'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Details Popup -->
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
        <div class="details-title">Мастер</div>
        <div id="master-name" class="details-value"></div>
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
        <button id="reset-btn" class="btn btn-sm btn-warning">Сбросить</button>
    </div>
</div>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="<?= _SITEDIR_ ?>public/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?= _SITEDIR_ ?>public/plugins/apex/apexcharts.min.js"></script>

<script>
    $(function() {
        // Store appointments data
        var appointments = [];
        var currentSelectedService = 'all';
        var currentActiveAppointment = null;
        
        <?php
        // Prepare appointments data
        foreach ($this->orders as $order) {
            // Convert date format from DD.MM.YYYY to YYYY-MM-DD for calendar
            $dateParts = explode('.', $order->selectedDate);
            if (count($dateParts) == 3) {
                $calendarDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
                
                $status = $order->status;
                
                // Find master name
                $masterName = '';
                foreach ($this->users_list as $master) {
                    if ($master->id == $order->user_id) {
                        $masterName = $master->firstname . ' ' . $master->lastname;
                        break;
                    }
                }
                
                // Status text
                $statusText = 'Новая';
                if ($status === 'done') {
                    $statusText = 'Выполнено';
                } else if ($status === 'conflict') {
                    $statusText = 'Отменено';
                }
                
                echo "
                appointments.push({
                    id: " . $order->id . ",
                    title: '" . addslashes($order->service->title) . " - " . addslashes($order->name ?: 'Клиент') . "',
                    start: '" . $calendarDate . "T" . $order->selectedTime . ":00',
                    className: '" . $status . "',
                    serviceId: " . $order->service_id . ",
                    clientName: '" . addslashes($order->name ?: 'Не указано') . "',
                    clientPhone: '" . addslashes($order->tel ?: 'Не указано') . "',
                    price: " . $order->service->price . ",
                    master: '" . addslashes($masterName) . "',
                    status: '" . $status . "',
                    statusText: '" . $statusText . "'
                });
                ";
            }
        }
        ?>
        
        // Process appointments to add proper end times
        appointments.forEach(function(appointment) {
            // Calculate end time by adding duration minutes to start time
            if (appointment.start && appointment.duration) {
                var startMoment = moment(appointment.start);
                var endMoment = moment(startMoment).add(appointment.duration, 'minutes');
                appointment.end = endMoment.format('YYYY-MM-DDTHH:mm:00');
            }
        });
        
        // Add this directly before initializing FullCalendar to fix the specific error

// Patch for FullCalendar to prevent "Cannot read properties of undefined (reading 'event')" error
var originalRenderFgSegEls = null;
if (typeof $.fn.fullCalendar !== 'undefined') {
    // Wait for FullCalendar to be fully loaded
    $(document).ready(function() {
        // Find the FullCalendar prototype
        var fcProto = Object.getPrototypeOf($('#appointments-calendar').fullCalendar('getView'));
        if (fcProto && fcProto.constructor && fcProto.constructor.prototype) {
            // Store original method
            var renderFgSegElsProto = fcProto.constructor.prototype.renderFgSegEls;
            
            // Override the method that's causing the error
            fcProto.constructor.prototype.renderFgSegEls = function(segs) {
                // Make sure segs is valid and each seg has an event property
                if (segs && Array.isArray(segs)) {
                    segs = segs.filter(function(seg) {
                        return seg && typeof seg === 'object' && seg.event;
                    });
                }
                // Call original method with filtered segments
                return renderFgSegElsProto.call(this, segs);
            };
        }
    });
}

// Then initialize FullCalendar as usual
$('#appointments-calendar').fullCalendar({
    header: {
        left: 'prev,next today',
        center: 'title',
        right: ''
    },
    defaultView: 'month',
    navLinks: true,
    editable: false,
    eventLimit: true,
    events: appointments,
    timeFormat: 'H:mm',
    slotLabelFormat: 'H:mm',
    minTime: '08:00:00',
    maxTime: '21:00:00',
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
        
        // Prepare revenue trend data
        const revenueTrendData = prepareRevenueTrendData();
        
        // Prepare service popularity data
        const servicePopularityData = prepareServicePopularityData();
        
        // Initialize revenue trend chart
        const revenueTrendChart = new ApexCharts(document.querySelector("#revenue-trend-chart"), {
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            series: [{
                name: 'Доход',
                data: revenueTrendData.data
            }],
            xaxis: {
                type: 'datetime',
                categories: revenueTrendData.categories
            },
            tooltip: {
                x: {
                    format: 'dd MMM yyyy'
                },
                y: {
                    formatter: function(val) {
                        return val + " грн";
                    }
                }
            },
            colors: ['#10b981'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                }
            }
        });
        
        revenueTrendChart.render();
        
        // Initialize service popularity chart
        const servicePopularityChart = new ApexCharts(document.querySelector("#service-popularity-chart"), {
            chart: {
                type: 'donut',
                height: 350
            },
            series: servicePopularityData.data,
            labels: servicePopularityData.labels,
            colors: ['#f59e0b', '#3b82f6', '#10b981', '#8b5cf6', '#ec4899', '#6366f1', '#14b8a6', '#f43f5e'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " записей";
                    }
                }
            }
        });
        
        servicePopularityChart.render();
        
        // Service filter handling for calendar
        $('#service-filter').on('change', function() {
            currentSelectedService = $(this).val();
            $('#appointments-calendar').fullCalendar('rerenderEvents');
        });
        
        // Filter handling for dashboard
        $('#apply-filters').on('click', function() {
            applyFilters();
        });
        
        // Function to show appointment details
        function showAppointmentDetails(appointment, jsEvent) {
            currentActiveAppointment = appointment;
            
            // Populate details
            $('#service-name').text(appointment.title.split(' - ')[0]);
            $('#client-name').text(appointment.clientName);
            $('#client-phone').text(appointment.clientPhone);
            $('#master-name').text(appointment.master);
            $('#appointment-time').text(moment(appointment.start).format('DD.MM.YYYY HH:mm'));
            $('#service-price').text(appointment.price + ' грн');
            
            // Set status badge
            var statusBadge = '<span class="status-badge status-' + appointment.status + '">' + appointment.statusText + '</span>';
            $('#status-badge').html(statusBadge);
            
            // Setup buttons
            $('#complete-btn').data('id', appointment.id);
            $('#cancel-btn').data('id', appointment.id);
            $('#reset-btn').data('id', appointment.id);
            
            // Hide buttons based on current status
            if (appointment.status === 'done') {
                $('#complete-btn').hide();
            } else {
                $('#complete-btn').show();
            }
            
            if (appointment.status === 'conflict') {
                $('#cancel-btn').hide();
            } else {
                $('#cancel-btn').show();
            }
            
            if (appointment.status === 'new') {
                $('#reset-btn').hide();
            } else {
                $('#reset-btn').show();
            }
            
            // Position and show the details popup
            var details = $('#appointment-details');
            
            // Get window dimensions
            var windowWidth = $(window).width();
            var windowHeight = $(window).height();
            
            // Get popup dimensions
            var popupWidth = details.outerWidth();
            var popupHeight = details.outerHeight();
            
            // Calculate position
            var top = jsEvent.pageY - 20;
            var left = jsEvent.pageX + 20;
            
            // Adjust position to keep within screen
            if (left + popupWidth > windowWidth - 10) {
                left = jsEvent.pageX - popupWidth - 20;
            }
            
            if (top + popupHeight > windowHeight - 10) {
                top = windowHeight - popupHeight - 10;
            }
            
            // Position and show popup
            details.css({
                top: top,
                left: left
            }).show();
        }
        
        // Appointment details close button
        $('#close-appointment-details').on('click', function() {
            $('#appointment-details').hide();
        });
        
        // Handle clicking outside the appointment details to close
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#appointment-details, .fc-event').length) {
                $('#appointment-details').hide();
            }
        });
        
        // Event handlers for appointment actions
        $('#complete-btn').on('click', function() {
            var id = $(this).data('id');
            changeOrderStatus(id, 'done');
            $('#appointment-details').hide();
        });
        
        $('#cancel-btn').on('click', function() {
            var id = $(this).data('id');
            if (confirm('Вы уверены, что хотите отменить запись?')) {
                changeOrderStatus(id, 'conflict');
                $('#appointment-details').hide();
            }
        });
        
        $('#reset-btn').on('click', function() {
            var id = $(this).data('id');
            changeOrderStatus(id, 'new');
            $('#appointment-details').hide();
        });
        
        // Helper functions
        function prepareRevenueTrendData() {
            const revenue = {};
            
            // Group revenue by date
            <?php foreach ($this->orders as $order): ?>
                <?php if ($order->status === 'done'): ?>
                    var date = '<?= $order->selectedDate ?>';
                    var dateParts = date.split('.');
                    var isoDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
                    
                    if (!revenue[isoDate]) {
                        revenue[isoDate] = 0;
                    }
                    
                    revenue[isoDate] += <?= $order->service->price ?>;
                <?php endif; ?>
            <?php endforeach; ?>
            
            // Sort dates and prepare data for chart
            const sortedDates = Object.keys(revenue).sort();
            const categories = [];
            const data = [];
            
            for (let date of sortedDates) {
                categories.push(date);
                data.push(revenue[date]);
            }
            
            return { categories, data };
        }
        
        function prepareServicePopularityData() {
            const serviceCount = {};
            
            // Count services
            <?php foreach ($this->orders as $order): ?>
                var serviceId = <?= $order->service_id ?>;
                var serviceName = '<?= $order->service->title ?>';
                
                if (!serviceCount[serviceId]) {
                    serviceCount[serviceId] = {
                        name: serviceName,
                        count: 0
                    };
                }
                
                serviceCount[serviceId].count++;
            <?php endforeach; ?>
            
            // Prepare data for chart
            const labels = [];
            const data = [];
            
            for (let serviceId in serviceCount) {
                labels.push(serviceCount[serviceId].name);
                data.push(serviceCount[serviceId].count);
            }
            
            return { labels, data };
        }
        
        function applyFilters() {
            const dateFrom = $('#date-from').val();
            const dateTo = $('#date-to').val();
            const shopId = $('#shop-filter').val();
            const masterId = $('#master-filter').val();
            
            // Validation - ensure date range is valid
            if (dateFrom && dateTo && new Date(dateFrom) > new Date(dateTo)) {
                alert('Дата начала не может быть позже даты окончания');
                return;
            }
            
            // Build URL with query parameters
            let url = window.location.pathname;
            let params = [];
            
            if (dateFrom) params.push('date_from=' + encodeURIComponent(dateFrom));
            if (dateTo) params.push('date_to=' + encodeURIComponent(dateTo));
            if (shopId !== 'all') params.push('shop_id=' + encodeURIComponent(shopId));
            if (masterId !== 'all') params.push('master_id=' + encodeURIComponent(masterId));
            
            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            
            window.location.href = url;
        }
    });
    
    // Function to change order status - this is outside the document ready function
    function changeOrderStatus(orderId, status, needConfirm = false) {
        if (needConfirm && !confirm('Вы уверены, что хотите отменить запись?')) {
            return;
        }
        
        // Show visual feedback that change is happening
        const statusBadge = document.getElementById('status-badge-' + orderId);
        if (statusBadge) {
            statusBadge.classList.add('status-changing');
        }
        
        // Call the status change endpoint
        load('panel/orders/change_status/' + orderId, 'status=' + status);
        
        // Update UI after a short delay to allow the server to process
        setTimeout(function() {
            location.reload();
        }, 800);
    }
</script>