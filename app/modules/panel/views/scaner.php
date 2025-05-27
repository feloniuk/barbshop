<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<!-- Статистика відвідуваності -->
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-12">
            <div class="page-header">
                <h2>Статистика відвідуваності</h2>
                <div class="filter-container">
                    <div>
                        <span class="filter-label">Період:</span>
                        <div class="date-range-picker">
                            <input type="date" id="date-from" name="date_from" class="form-control" value="<?= get('date_from') ?: date('Y-m-01') ?>">
                            <span>—</span>
                            <input type="date" id="date-to" name="date_to" class="form-control" value="<?= get('date_to') ?: date('Y-m-t') ?>">
                        </div>
                    </div>
                    
                    <?php if (User::checkRole('admin')): ?>
                    <div>
                        <span class="filter-label">Барбершоп:</span>
                        <select id="shop-filter" class="form-control">
                            <option value="">Всі барбершопи</option>
                            <?php foreach ($this->shops as $shop): ?>
                                <option value="<?= $shop->id ?>" <?= get('shop_id') == $shop->id ? 'selected': '' ?>><?= $shop->title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    
                    <div>
                        <span class="filter-label">Працівник:</span>
                        <select id="user-filter" class="form-control">
                            <option value="">Всі працівники</option>
                            <?php foreach ($this->users as $user): ?>
                                <option value="<?= $user->id ?>" <?= get('user_id') == $user->id ? 'selected': '' ?>><?= $user->firstname . ' ' . $user->lastname ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button id="apply-filters" class="btn btn-primary">Застосувати</button>
                    <button id="export-excel" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download mr-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Експорт Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Загальна статистика -->
    <div class="row layout-spacing">
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
            <div class="dashboard-card">
                <div class="card-icon icon-green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                </div>
                <div class="card-label">Присутні сьогодні</div>
                <div class="card-stat"><?= $this->todayPresent ?></div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
            <div class="dashboard-card">
                <div class="card-icon icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <div class="card-label">Робочих днів</div>
                <div class="card-stat"><?= $this->totalWorkDays ?></div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
            <div class="dashboard-card">
                <div class="card-icon icon-yellow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div class="card-label">Загальні години</div>
                <div class="card-stat"><?= round($this->totalHours, 1) ?> год</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
            <div class="dashboard-card">
                <div class="card-icon icon-purple">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>
                </div>
                <div class="card-label">Середній час</div>
                <div class="card-stat"><?= round($this->avgHours, 1) ?> год/день</div>
            </div>
        </div>
    </div>

    <!-- Зведена статистика по працівниках -->
    <div class="row layout-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-one">
                <div class="widget-heading">
                    <h4>Зведена статистика по працівниках</h4>
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Працівник</th>
                                    <th>Робочих днів</th>
                                    <th>Загальні години</th>
                                    <th>Середні години/день</th>
                                    <th>Запізнень</th>
                                    <th>Пропусків</th>
                                    <th>% Присутності</th>
                                    <th>Дії</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->summaryStats as $stat): ?>
                                    <?php 
                                    $attendanceRate = $stat->total_days > 0 ? 
                                        round(($stat->present_days / $stat->total_days) * 100, 1) : 0;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if ($stat->image): ?>
                                                    <img src="<?= _SITEDIR_ . Storage::shardDir('users', $stat->id) . $stat->image ?>" 
                                                         alt="<?= $stat->firstname ?>" 
                                                         class="avatar rounded-circle mr-2" 
                                                         style="width: 32px; height: 32px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="avatar rounded-circle mr-2 bg-primary d-flex align-items-center justify-content-center" 
                                                         style="width: 32px; height: 32px;">
                                                        <?= mb_substr($stat->firstname, 0, 1) . mb_substr($stat->lastname, 0, 1) ?>
                                                    </div>
                                                <?php endif; ?>
                                                <span><?= $stat->firstname . ' ' . $stat->lastname ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center"><?= $stat->present_days ?: 0 ?></td>
                                        <td class="text-center"><?= round($stat->total_hours ?: 0, 1) ?> год</td>
                                        <td class="text-center"><?= round($stat->avg_hours ?: 0, 1) ?> год</td>
                                        <td class="text-center">
                                            <span class="badge badge-warning"><?= $stat->late_days ?: 0 ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-danger"><?= $stat->absent_days ?: 0 ?></span>
                                        </td>
                                        <td class="text-center">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar <?= $attendanceRate >= 90 ? 'bg-success' : ($attendanceRate >= 70 ? 'bg-warning' : 'bg-danger') ?>" 
                                                     role="progressbar" 
                                                     style="width: <?= $attendanceRate ?>%">
                                                    <?= $attendanceRate ?>%
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info view-details" data-user-id="<?= $stat->id ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Детальна таблиця відвідуваності -->
    <div class="row layout-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-two">
                <div class="widget-heading">
                    <h4>Детальна відвідуваність</h4>
                </div>
                <div class="widget-content">
                    <div class="table-responsive">
                        <table id="attendance-table" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Працівник</th>
                                    <th>Барбершоп</th>
                                    <th>Вхід</th>
                                    <th>Вихід</th>
                                    <th>Відпрацьовано</th>
                                    <th>Статус</th>
                                    <th>Примітки</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->attendanceRecords as $record): ?>
                                    <tr>
                                        <td><?= date('d.m.Y', strtotime($record->date)) ?></td>
                                        <td><?= $record->firstname . ' ' . $record->lastname ?></td>
                                        <td><?= $record->shop_name ?: '-' ?></td>
                                        <td><?= $record->check_in ? date('H:i', strtotime($record->check_in)) : '-' ?></td>
                                        <td><?= $record->check_out ? date('H:i', strtotime($record->check_out)) : '-' ?></td>
                                        <td><?= $record->hours_worked ? round($record->hours_worked, 1) . ' год' : '-' ?></td>
                                        <td>
                                            <?php
                                            $statusClass = '';
                                            $statusText = '';
                                            switch ($record->status) {
                                                case 'present':
                                                    $statusClass = 'badge-success';
                                                    $statusText = 'Присутній';
                                                    break;
                                                case 'late':
                                                    $statusClass = 'badge-warning';
                                                    $statusText = 'Запізнення';
                                                    break;
                                                case 'absent':
                                                    $statusClass = 'badge-danger';
                                                    $statusText = 'Відсутній';
                                                    break;
                                                case 'day_off':
                                                    $statusClass = 'badge-secondary';
                                                    $statusText = 'Вихідний';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                        </td>
                                        <td><?= $record->notes ?: '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальне вікно для деталей працівника -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Детальна статистика працівника</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="userDetailsContent">
                <!-- Завантажується динамічно -->
            </div>
        </div>
    </div>
</div>

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
    
    .icon-yellow { background-color: rgba(245, 158, 11, 0.1); }
    .icon-blue { background-color: rgba(59, 130, 246, 0.1); }
    .icon-green { background-color: rgba(16, 185, 129, 0.1); }
    .icon-purple { background-color: rgba(139, 92, 246, 0.1); }
    
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
</style>

<script>
$(document).ready(function() {
    // DataTable
    $('#attendance-table').DataTable({
        "order": [[0, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Ukrainian.json"
        }
    });
    
    // Фільтри
    $('#apply-filters').on('click', function() {
        const dateFrom = $('#date-from').val();
        const dateTo = $('#date-to').val();
        const shopId = $('#shop-filter').val();
        const userId = $('#user-filter').val();
        
        let url = window.location.pathname + '?';
        const params = [];
        
        if (dateFrom) params.push('date_from=' + dateFrom);
        if (dateTo) params.push('date_to=' + dateTo);
        if (shopId) params.push('shop_id=' + shopId);
        if (userId) params.push('user_id=' + userId);
        
        window.location.href = url + params.join('&');
    });
    
    // Експорт в Excel
    $('#export-excel').on('click', function() {
        const dateFrom = $('#date-from').val();
        const dateTo = $('#date-to').val();
        const shopId = $('#shop-filter').val();
        const userId = $('#user-filter').val();
        
        let url = '{URL:panel/attendance/export}?';
        const params = [];
        
        if (dateFrom) params.push('date_from=' + dateFrom);
        if (dateTo) params.push('date_to=' + dateTo);
        if (shopId) params.push('shop_id=' + shopId);
        if (userId) params.push('user_id=' + userId);
        
        window.location.href = url + params.join('&');
    });
    
    // Деталі працівника
    $('.view-details').on('click', function() {
        const userId = $(this).data('user-id');
        const dateFrom = $('#date-from').val();
        const dateTo = $('#date-to').val();
        
        $('#userDetailsContent').html('<div class="text-center py-4"><div class="spinner-border"></div></div>');
        $('#userDetailsModal').modal('show');
        
        load('panel/attendance/user_details/' + userId, 
             'date_from=' + dateFrom + '&date_to=' + dateTo, 
             'html:#userDetailsContent');
    });
});
</script>