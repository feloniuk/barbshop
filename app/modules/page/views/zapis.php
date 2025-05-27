<div class="bg-gray-900 text-white flex flex-col items-center p-5" id="main_id">
  <div id="loader" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="w-16 h-16 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
  </div>

  <div class="w-full max-w-md">
    <!-- Booking steps container -->
    <div id="bookingSteps">
      <!-- Step 1: Date and Time Selection -->
      <div id="dateTimeSelection">
        <!-- <?php include(_SYSDIR_ . 'modules/page/views/success.php'); ?> -->
        <div class="bg-gray-800 p-4 rounded-lg relative">
          <h2 id="monthTitle" class="text-center text-lg font-bold mb-2"></h2>
          <div id="calendar" class="grid grid-cols-7 gap-2 text-center"></div>
          <input type="hidden" id="selectedDate" name="selectedDate">
        </div>

        <div class="bg-gray-800 p-4 rounded-lg mt-4">
          <h3 class="text-lg font-bold mb-2">Выбор времени</h3>
          <div id="timeSlots" class="grid grid-cols-3 gap-2"></div>
          <input type="hidden" id="selectedTime" name="selectedTime">
        </div>

        <button id="proceedToContactBtn" class="w-full bg-blue-600 p-3 rounded-lg text-center mt-4">Записаться</button>
      </div>

      <!-- Step 2: Contact Information Form -->
      <div id="contactForm" class="hidden">
        <div class="bg-gray-800 p-4 rounded-lg">
          <h3 class="text-lg font-bold mb-4">Контактная информация</h3>

          <div class="mb-4">
            <label for="clientName" class="block text-sm mb-1">Имя*</label>
            <input type="text" id="clientName" class="w-full bg-gray-700 p-2 rounded text-white" required>
          </div>

          <div class="mb-4">
            <label for="clientPhone" class="block text-sm mb-1">Телефон*</label>
            <input type="tel" id="clientPhone" class="w-full bg-gray-700 p-2 rounded text-white" required>
          </div>

          <div class="mb-4">
            <label for="clientEmail" class="block text-sm mb-1">Email (опционально)</label>
            <input type="email" id="clientEmail" class="w-full bg-gray-700 p-2 rounded text-white">
          </div>

          <div class="bg-gray-700 p-3 rounded-lg mt-2 mb-4">
            <p class="text-sm mb-1 font-bold">Выбранное время:</p>
            <p id="summaryDateTime" class="text-sm"></p>
          </div>

          <div class="flex gap-2">
            <button id="backToDateTimeBtn" class="flex-1 bg-gray-600 p-3 rounded-lg text-center">Назад</button>
            <button id="submitBookingBtn" class="flex-1 bg-blue-600 p-3 rounded-lg text-center">Отправить</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $("#clientPhone").inputmask({
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

    <?php
    // Get service time from URL parameter
    $service_id = isset($_GET['service']) ? (int)$_GET['service'] : 0;
    $service_time = 0.5; // Default service time (30 minutes)

    // Generate busyTimesRanges object from $this->orders
    $busyTimesRanges = [];
    if (isset($this->orders) && !empty($this->orders)) {
      foreach ($this->orders as $order) {
        $date = $order->selectedDate;
        $time = $order->selectedTime;
        $duration = isset($order->service->service_time) ? (float)$order->service->service_time : 0.5;

        if (!isset($busyTimesRanges[$date])) {
          $busyTimesRanges[$date] = [];
        }

        // Add this time slot
        $busyTimesRanges[$date][] = [
          'start' => $time,
          'duration' => $duration
        ];
      }
    }

    // Output as JavaScript
    echo "const currentServiceTime = " . (isset($_GET['service']) && isset($this->services[$service_id]->service_time) ? (float)$this->services[$service_id]->service_time : 0.5) . ";\n";
    echo "const busyTimesRanges = " . json_encode($busyTimesRanges) . ";\n";
    ?>

    const workStart = '<?= $this->shop->time_from ?>';
    const workEnd = '<?= $this->shop->time_to ?>';
    const availableDates = [];
    const today = new Date(); // Сегодняшняя дата

    // For simple time slot checks
    const busyTimes = {};

    // Process busyTimesRanges to generate all affected time slots
    for (const date in busyTimesRanges) {
      busyTimes[date] = [];

      busyTimesRanges[date].forEach(booking => {
        const startTime = booking.start;
        const duration = booking.duration;

        // Calculate how many 30-minute slots this service needs
        const slotsNeeded = Math.ceil(duration * 2); // multiply by 2 because each slot is 30 minutes

        // Add all affected time slots
        let currentSlot = startTime;
        for (let i = 0; i < slotsNeeded; i++) {
          busyTimes[date].push(currentSlot);

          // Calculate next 30-minute slot
          let [hours, minutes] = currentSlot.split(':').map(Number);
          minutes += 30;
          if (minutes >= 60) {
            minutes = 0;
            hours += 1;
          }
          currentSlot = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
        }
      });
    }

    // Цикл на 7 дней
    for (let i = 0; i < 7; i++) {
      const nextDate = new Date(today); // Копируем сегодняшнюю дату
      nextDate.setDate(today.getDate() + i); // Увеличиваем день на i
      // Форматируем дату в формат "день.месяц.год"
      const formattedDate = nextDate.toLocaleDateString('ru-RU').replaceAll('.', '.');
      availableDates.push(formattedDate);
    }

    function toggleLoader() {
      document.getElementById('loader').classList.toggle('hidden');
    }

    function getDayOfWeek(dateStr) {
      const [day, month, year] = dateStr.split('.').map(Number);
      const date = new Date(year, month - 1, day);
      return ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'][date.getDay()];
    }

    function getMonthName(monthNumber) {
      const months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
      return months[monthNumber - 1];
    }

    function generateCalendar() {
      const calendarContainer = document.getElementById('calendar');
      calendarContainer.innerHTML = '';

      if (availableDates.length > 0) {
        const firstDate = availableDates[0];
        const monthNumber = parseInt(firstDate.split('.')[1]);
        document.getElementById('monthTitle').textContent = getMonthName(monthNumber);
      }

      availableDates.forEach(date => {
        let button = document.createElement('button');
        button.className = 'day bg-gray-700 p-2 rounded text-center flex flex-col items-center';
        button.innerHTML = `<span class="text-sm">${getDayOfWeek(date)}</span><span class="text-lg font-bold">${date.substring(0, 5)}</span>`;
        button.dataset.date = date;

        // Проверяем, если это сегодняшний день и время уже прошло, то блокируем кнопку
        if (date === formatDate(today)) {
          const currentTime = formatTime(today);
          if (currentTime > workEnd) {
            button.classList.add('opacity-50', 'cursor-not-allowed');
          }
        }

        // Select the previously selected date if available
        if (date === document.getElementById('selectedDate').value) {
          button.classList.add('bg-blue-500');
        }

        button.addEventListener('click', function() {
          document.querySelectorAll('.day').forEach(d => d.classList.remove('bg-blue-500'));
          this.classList.add('bg-blue-500');
          document.getElementById('selectedDate').value = this.dataset.date;
          generateTimeSlots(this.dataset.date);
        });
        calendarContainer.appendChild(button);
      });

      // Generate time slots for the selected date if there is one
      const selectedDate = document.getElementById('selectedDate').value;
      if (selectedDate) {
        generateTimeSlots(selectedDate);
      }
    }

    // Check if selecting this time would conflict with existing bookings
    function wouldTimeConflict(date, time) {
      // If there are no bookings on this date, no conflict
      if (!busyTimes[date]) return false;

      // Calculate how many 30-minute slots the current service needs
      const slotsNeeded = Math.ceil(currentServiceTime * 2);

      // Check each slot that would be occupied by this service
      let currentSlot = time;
      for (let i = 0; i < slotsNeeded; i++) {
        // If this slot is already booked, there's a conflict
        if (busyTimes[date].includes(currentSlot)) {
          return true;
        }

        // Calculate next 30-minute slot
        let [hours, minutes] = currentSlot.split(':').map(Number);
        minutes += 30;
        if (minutes >= 60) {
          minutes = 0;
          hours += 1;
        }

        // If we've reached the end of the work day, no need to check further
        if (hours >= parseInt(workEnd.split(':')[0])) {
          break;
        }

        currentSlot = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
      }

      return false;
    }

    // Check if selecting this time would extend beyond working hours
    function wouldExceedWorkingHours(time) {
      // Calculate the end time of this service
      const duration = currentServiceTime * 60; // in minutes
      let [hours, minutes] = time.split(':').map(Number);

      // Add the service duration
      minutes += duration;
      while (minutes >= 60) {
        minutes -= 60;
        hours += 1;
      }

      const serviceEndTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;

      // Check if service end time is after work end time
      return serviceEndTime > workEnd;
    }

    function generateTimeSlots(date) {
      const timeSlotsContainer = document.getElementById('timeSlots');
      timeSlotsContainer.innerHTML = '';
      let currentTime = workStart.split(':').map(Number);
      let endTime = workEnd.split(':').map(Number);
      const selectedTimeValue = document.getElementById('selectedTime').value;

      while (currentTime[0] < endTime[0] || (currentTime[0] === endTime[0] && currentTime[1] < endTime[1])) {
        let formattedTime = `${String(currentTime[0]).padStart(2, '0')}:${String(currentTime[1]).padStart(2, '0')}`;

        // Check if this time would conflict with existing bookings or exceed working hours
        let isBusy = wouldTimeConflict(date, formattedTime) || wouldExceedWorkingHours(formattedTime);

        let button = document.createElement('button');
        button.className = `time bg-gray-700 p-2 rounded ${isBusy ? 'opacity-50 cursor-not-allowed' : ''}`;

        // Блокируем прошедшее время на текущем дне
        if (date === formatDate(today) && formattedTime < formatTime(today)) {
          button.classList.add('opacity-50', 'cursor-not-allowed');
          isBusy = true;
        }

        button.textContent = formattedTime;
        button.dataset.time = formattedTime;

        // Select the previously selected time if available
        if (formattedTime === selectedTimeValue) {
          button.classList.add('bg-blue-500');
        }

        if (!isBusy) {
          button.addEventListener('click', function() {
            document.querySelectorAll('.time').forEach(t => t.classList.remove('bg-blue-500'));
            this.classList.add('bg-blue-500');
            document.getElementById('selectedTime').value = this.dataset.time;
          });
        }
        timeSlotsContainer.appendChild(button);

        currentTime[1] += 30;
        if (currentTime[1] === 60) {
          currentTime[1] = 0;
          currentTime[0] += 1;
        }
      }
    }

    function formatDate(date) {
      return date.toLocaleDateString('ru-RU').replaceAll('.', '.');
    }

    function formatTime(date) {
      return `${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
    }

    function updateSummary() {
      const selectedDate = document.getElementById('selectedDate').value;
      const selectedTime = document.getElementById('selectedTime').value;
      let summaryText = '';

      if (selectedDate && selectedTime) {
        const dayOfWeek = getDayOfWeek(selectedDate);

        // Calculate service end time for display
        const duration = currentServiceTime * 60; // in minutes
        let [hours, minutes] = selectedTime.split(':').map(Number);

        // Add the service duration
        minutes += duration;
        while (minutes >= 60) {
          minutes -= 60;
          hours += 1;
        }

        const serviceEndTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;

        summaryText = `${dayOfWeek}, ${selectedDate} с ${selectedTime} до ${serviceEndTime}`;
      } else {
        summaryText = 'Время не выбрано';
      }

      document.getElementById('summaryDateTime').textContent = summaryText;
    }

    // Initialize the calendar
    generateCalendar();

    // Event listeners for navigation between steps
    document.getElementById('proceedToContactBtn').addEventListener('click', function() {
      const selectedDate = document.getElementById('selectedDate').value;
      const selectedTime = document.getElementById('selectedTime').value;

      if (!selectedDate || !selectedTime) {
        noticeError('Пожалуйста, выберите дату и время');
        return;
      }

      updateSummary();
      document.getElementById('dateTimeSelection').classList.add('hidden');
      document.getElementById('contactForm').classList.remove('hidden');
    });

    document.getElementById('backToDateTimeBtn').addEventListener('click', function() {
      document.getElementById('contactForm').classList.add('hidden');
      document.getElementById('dateTimeSelection').classList.remove('hidden');
    });

    document.getElementById('submitBookingBtn').addEventListener('click', function() {
      const clientName = document.getElementById('clientName').value;
      const clientPhone = document.getElementById('clientPhone').value;

      if (!clientName || !clientPhone) {
        noticeError('Пожалуйста, заполните обязательные поля');
        return;
      }

      toggleLoader();

      // Here you would normally send the data to the server
      const selectedDate = document.getElementById('selectedDate').value;
      const selectedTime = document.getElementById('selectedTime').value;
      const clientEmail = document.getElementById('clientEmail').value;

      // Replace this with your actual submission logic
      setTimeout(function() {
        toggleLoader();
        load('page/zapis_service?shop=<?= get('shop') ?>&barber=<?= get('barber') ?>&service=<?= get('service') ?>',
          'selectedDate#selectedDate',
          'selectedTime#selectedTime',
          'name#clientName',
          'tel#clientPhone',
          'email#clientEmail');
      }, 500);
    });
  </script>

</div>