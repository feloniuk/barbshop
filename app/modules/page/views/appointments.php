<!-- Main Content Container -->
<div class=" mx-auto px-4 md:px-8 py-12 bg-[#0a0a0a] text-white">
    <!-- Page Heading -->
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-bold mb-3">Проверка записей</h2>
        <p class="text-gray-400 max-w-2xl mx-auto">Введите номер телефона, указанный при бронировании, чтобы найти ваши записи</p>
    </div>

    <!-- Phone Search Form -->
    <div class="max-w-md mx-auto mb-12">
        <div class="bg-[#111] border border-gray-800 rounded-xl p-6 shadow-lg">
            <form id="search-form" class="space-y-4">
                <div>
                    <label for="phone" class="block text-sm text-gray-400 mb-2">Номер телефона</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <input type="tel" id="phone" name="phone" class="bg-[#1a1a1a] border border-gray-700 text-white rounded-lg block w-full pl-10 pr-3 py-3 focus:ring-blue-500 focus:border-blue-500" placeholder="+380 XX XXX XX XX" required>
                    </div>
                </div>
                <button type="submit" class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold tracking-wider hover:opacity-90 transition-all duration-300 text-sm uppercase">
                    Найти записи
                </button>
            </form>
        </div>
    </div>

    <!-- Initial State Message (Shown by default) -->
    <div id="initial-state" class="text-center py-16">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#1a1a1a] flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-2">Проверка записей</h3>
        <p class="text-gray-400 mb-6">Введите номер телефона выше, чтобы найти свои записи на стрижку</p>
    </div>

    <!-- Results Heading (Hidden until search is performed) -->
    <div id="results-heading" class="mb-6 hidden">
        <h3 class="text-2xl font-semibold mb-2">Найденные записи</h3>
        <p class="text-gray-400">Записи для номера: <span id="search-phone" class="font-medium text-blue-400"></span></p>
    </div>

    <!-- Results Container (Hidden until search is performed) -->
    <div id="results-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
        <!-- Appointment cards will be dynamically inserted here -->
    </div>

    <!-- No Results Message (Hidden by default) -->
    <div id="no-results" class="text-center py-10 hidden">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#1a1a1a] flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <h3 class="text-xl font-semibold mb-2">Записи не найдены</h3>
        <p class="text-gray-400 mb-6">По указанному номеру телефона не найдено активных записей</p>
        <a href="{LINK:/book}" class="px-6 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold tracking-wider hover:opacity-90 transition-all duration-300 inline-block">
            Забронировать
        </a>
    </div>

    <!-- Loading Indicator (Hidden by default) -->
    <div id="loading-indicator" class="text-center py-16 hidden">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 p-1 animate-spin">
            <div class="w-full h-full rounded-full bg-[#111]"></div>
        </div>
        <p class="text-gray-400">Поиск записей...</p>
    </div>

    <!-- Single Appointment Template (For JS to clone) -->
    <template id="appointment-template">
        <div class="appointment-card bg-[#111] border border-gray-800 rounded-2xl overflow-hidden shadow-lg transform transition-all duration-300 hover:scale-[1.02] hover:border-gray-700">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <span class="status-badge px-3 py-1 rounded-full text-xs font-medium"></span>
                </div>
                
                <h3 class="service-title text-xl font-bold mb-3"></h3>
                
                <div class="bg-[#1a1a1a] rounded-xl p-4 mb-6 border border-gray-800">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="text-left">
                            <p class="text-xs text-gray-500 mb-1">Дата</p>
                            <p class="appointment-date text-white font-semibold"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 mb-1">Время</p>
                            <p class="appointment-time text-white font-semibold"></p>
                        </div>
                        <div class="text-left">
                            <p class="text-xs text-gray-500 mb-1">Клиент</p>
                            <p class="client-name text-white font-semibold"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 mb-1">Телефон</p>
                            <p class="client-phone text-white font-semibold"></p>
                        </div>
                        <div class="text-left">
                            <p class="text-xs text-gray-500 mb-1">Барбершоп</p>
                            <p class="shop-name text-white font-semibold"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 mb-1">Мастер</p>
                            <p class="master-name text-white font-semibold"></p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="service-price text-lg font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"></span>
                    <button class="cancel-btn px-4 py-2 bg-red-600 bg-opacity-20 border border-red-600 border-opacity-30 rounded-lg text-red-500 hover:bg-opacity-30 transition duration-300 text-sm">
                        Отменить
                    </button>
                </div>
            </div>
        </div>
    </template>

    <!-- Cancel Confirmation Dialog -->
    <div id="cancel-dialog" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-75 hidden">
        <div class="w-full max-w-sm bg-[#111] border border-gray-800 rounded-2xl overflow-hidden shadow-2xl">
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center" style="background-color: rgba(239, 68, 68, 0.2);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold mb-2">Отменить запись?</h3>
                <p class="text-gray-400 mb-6">Вы уверены, что хотите отменить запись? Это действие нельзя отменить.</p>
                
                <div class="flex space-x-3 justify-center">
                    <button onclick="hideCancelDialog()" class="px-4 py-2 border border-gray-700 rounded-lg text-white hover:bg-gray-800 transition duration-300">
                        Отмена
                    </button>
                    <button id="confirm-cancel-btn" class="px-4 py-2 bg-red-600 rounded-lg text-white hover:bg-red-700 transition duration-300">
                        Да, отменить
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for functionality -->
<script>
    $(document).ready(function() {
      $("#phone").inputmask({
        mask: [
          "+38 (099) 999-99-99" // Украина
        ],
        greedy: false,
        definitions: {
          '9': {
            validator: "[0-9]",
            cardinality: 1
          }
        }
      });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('search-form');
        const initialState = document.getElementById('initial-state');
        const resultsHeading = document.getElementById('results-heading');
        const searchPhoneDisplay = document.getElementById('search-phone');
        const resultsContainer = document.getElementById('results-container');
        const noResults = document.getElementById('no-results');
        const loadingIndicator = document.getElementById('loading-indicator');
        const appointmentTemplate = document.getElementById('appointment-template');
        const cancelDialog = document.getElementById('cancel-dialog');
        const confirmCancelBtn = document.getElementById('confirm-cancel-btn');
        
        // All future appointments data
        let allAppointments = [
            <?php if ($this->orders) foreach ($this->orders as $order) { ?>
                {
                id: 1,
                service: "<?= $order->service->title ?>",
                date: "<?= $order->selectedDate ?>",
                time: "<?= $order->selectedTime ?>",
                client: "<?= $order->name ?>",
                phone: "<?= $order->tel ?>",
                shop: "<?= $order->shop->title ?>",
                master: "<?= $order->user->firstname ?>",
                price: <?= $order->service->price ?>,
                status: "<?= $order->status ?>" // new, done, conflict
            },
            <?php } ?>
        ];
        
        // Handle form submission for search
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const phone = document.getElementById('phone').value.trim();
            
            if (phone === '') {
                noticeError('Пожалуйста, введите номер телефона');
                return;
            }
            
            // Show loading state
            initialState.classList.add('hidden');
            resultsHeading.classList.add('hidden');
            resultsContainer.classList.add('hidden');
            noResults.classList.add('hidden');
            loadingIndicator.classList.remove('hidden');
            
            // Update search display
            searchPhoneDisplay.textContent = phone;
            
            // Simulate API call with a timeout (replace with actual backend call)
            setTimeout(function() {
                // Filter appointments by phone number
                const filteredAppointments = allAppointments.filter(appointment => 
                    appointment.phone.includes(phone)
                );
                
                // Hide loading
                loadingIndicator.classList.add('hidden');
                
                if (filteredAppointments.length > 0) {
                    // Show results heading and container
                    resultsHeading.classList.remove('hidden');
                    resultsContainer.classList.remove('hidden');
                    
                    // Clear previous results
                    resultsContainer.innerHTML = '';
                    
                    // Create appointment cards
                    filteredAppointments.forEach(appointment => {
                        const card = document.importNode(appointmentTemplate.content, true).firstElementChild;
                        
                        // Set appointment details
                        card.querySelector('.service-title').textContent = appointment.service;
                        card.querySelector('.appointment-date').textContent = appointment.date;
                        card.querySelector('.appointment-time').textContent = appointment.time;
                        card.querySelector('.client-name').textContent = appointment.client;
                        card.querySelector('.client-phone').textContent = appointment.phone;
                        card.querySelector('.shop-name').textContent = appointment.shop;
                        card.querySelector('.master-name').textContent = appointment.master;
                        card.querySelector('.service-price').textContent = appointment.price + ' грн';
                        
                        // Set status badge
                        const statusBadge = card.querySelector('.status-badge');
                        if (appointment.status === 'new') {
                            statusBadge.textContent = 'Новая';
                            statusBadge.classList.add('bg-yellow-500');
                        } else if (appointment.status === 'done') {
                            statusBadge.textContent = 'Выполнено';
                            statusBadge.classList.add('bg-green-500');
                        } else if (appointment.status === 'conflict') {
                            statusBadge.textContent = 'Отменено';
                            statusBadge.classList.add('bg-red-500');
                        }
                        
                        // Hide cancel button for completed or cancelled appointments
                        const cancelBtn = card.querySelector('.cancel-btn');
                        if (appointment.status !== 'new') {
                            cancelBtn.style.display = 'none';
                        } else {
                            cancelBtn.setAttribute('data-id', appointment.id);
                            cancelBtn.addEventListener('click', function() {
                                showCancelDialog(appointment.id);
                            });
                        }
                        
                        // Add card to results container
                        resultsContainer.appendChild(card);
                    });
                } else {
                    // Show no results
                    noResults.classList.remove('hidden');
                }
            }, 1000); // Simulate network delay
        });
        
        // Show cancel confirmation dialog
        function showCancelDialog(appointmentId) {
            confirmCancelBtn.setAttribute('data-id', appointmentId);
            cancelDialog.classList.remove('hidden');
        }
        
        // Hide cancel confirmation dialog
        window.hideCancelDialog = function() {
            cancelDialog.classList.add('hidden');
        };
        
        // Handle cancel confirmation
        confirmCancelBtn.addEventListener('click', function() {
            const appointmentId = parseInt(this.getAttribute('data-id'));
            
            // In production, make an API call to cancel the appointment
            // For this demo, we'll update our local data
            
            // Find the appointment in our data
            const appointmentIndex = allAppointments.findIndex(a => a.id === appointmentId);
            
            if (appointmentIndex !== -1) {
                // Update status in our data
                allAppointments[appointmentIndex].status = 'conflict';
                
                // Hide dialog
                hideCancelDialog();
                
                // Re-filter and display
                const phone = document.getElementById('phone').value.trim();
                const filteredAppointments = allAppointments.filter(appointment => 
                    appointment.phone.includes(phone)
                );
                
                // Clear previous results
                resultsContainer.innerHTML = '';
                
                // Check if we still have results
                if (filteredAppointments.length > 0) {
                    // Create new appointment cards
                    filteredAppointments.forEach(appointment => {
                        const card = document.importNode(appointmentTemplate.content, true).firstElementChild;
                        
                        // Set appointment details
                        card.querySelector('.service-title').textContent = appointment.service;
                        card.querySelector('.appointment-date').textContent = appointment.date;
                        card.querySelector('.appointment-time').textContent = appointment.time;
                        card.querySelector('.client-name').textContent = appointment.client;
                        card.querySelector('.client-phone').textContent = appointment.phone;
                        card.querySelector('.shop-name').textContent = appointment.shop;
                        card.querySelector('.master-name').textContent = appointment.master;
                        card.querySelector('.service-price').textContent = appointment.price + ' грн';
                        
                        // Set status badge
                        const statusBadge = card.querySelector('.status-badge');
                        if (appointment.status === 'new') {
                            statusBadge.textContent = 'Новая';
                            statusBadge.classList.add('bg-yellow-500');
                        } else if (appointment.status === 'done') {
                            statusBadge.textContent = 'Выполнено';
                            statusBadge.classList.add('bg-green-500');
                        } else if (appointment.status === 'conflict') {
                            statusBadge.textContent = 'Отменено';
                            statusBadge.classList.add('bg-red-500');
                        }
                        
                        // Hide cancel button for completed or cancelled appointments
                        const cancelBtn = card.querySelector('.cancel-btn');
                        if (appointment.status !== 'new') {
                            cancelBtn.style.display = 'none';
                        } else {
                            cancelBtn.setAttribute('data-id', appointment.id);
                            cancelBtn.addEventListener('click', function() {
                                showCancelDialog(appointment.id);
                            });
                        }
                        
                        // Add card to results container
                        resultsContainer.appendChild(card);
                    });
                } else {
                    // No more appointments after cancellation
                    resultsContainer.classList.add('hidden');
                    resultsHeading.classList.add('hidden');
                    noResults.classList.remove('hidden');
                }
                
                // Optional: Show success message
                noticeError('Запись успешно отменена');
            }
        });
    });

</script>