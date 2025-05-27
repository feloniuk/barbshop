<div class="w-full max-w-md bg-[#111] border border-gray-800 rounded-2xl overflow-hidden shadow-2xl transform transition-all duration-300 hover:scale-[1.02]">
    <div class="p-6 text-center relative">
        <a href="{LINK:/}" class="absolute top-4 right-4 text-gray-500 hover:text-white cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </a>

        <div class="bg-gradient-to-r from-blue-600 to-purple-600 w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <h2 class="text-white text-2xl font-bold mb-2 tracking-tight">Бронирование подтверждено</h2>
        <p class="text-gray-400 mb-6 text-sm">Ваша стрижка зарезервирована</p>

        <div class="bg-[#1a1a1a] rounded-xl p-4 mb-6 border border-gray-800">
            <div class="grid grid-cols-2 gap-2">
                <div class="text-left">
                    <p class="text-xs text-gray-500 mb-1">Дата</p>
                    <p class="text-white font-semibold"><?= post('selectedDate') ?></p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 mb-1">Время</p>
                    <p class="text-white font-semibold"><?= post('selectedTime') ?></p>
                </div>
                <div class="text-left">
                    <p class="text-xs text-gray-500 mb-1">Имя</p>
                    <p class="text-white font-semibold"><?= post('name') ?></p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 mb-1">Телефон</p>
                    <p class="text-white font-semibold"><?= post('tel') ?></p>
                </div>
            </div>
        </div>

        <a  href="{LINK:/}" class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold tracking-wider hover:opacity-90 transition-all duration-300 text-sm uppercase">
            Понятно
        </a>
    </div>
</div>