<!-- Styles -->
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        background: #0a0a0a;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }

    .main {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .container {
        width: 100%;
        max-width: 800px;
        background: #111;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logo {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo h1 {
        font-size: 2.5em;
        background: linear-gradient(45deg, #f59e0b, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 10px;
    }

    .logo p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.1em;
    }

    /* Scanner styles */
    #scanner-container {
        position: relative;
        width: 100%;
        height: 300px;
        margin: 20px 0;
        border-radius: 15px;
        overflow: hidden;
        background: #000;
        border: 2px solid rgba(255, 255, 255, 0.1);
    }

    #scanner {
        width: 100%;
        height: 100%;
    }

    .scan-line {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #f59e0b, transparent);
        animation: scan 2s linear infinite;
    }

    @keyframes scan {
        0% { transform: translateY(0); }
        100% { transform: translateY(298px); }
    }

    /* Controls */
    .controls {
        text-align: center;
        margin-top: 30px;
    }

    .btn {
        background: linear-gradient(45deg, #f59e0b, #3b82f6);
        color: white;
        border: none;
        padding: 15px 40px;
        font-size: 1.1em;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        margin: 10px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn.secondary {
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    /* Shop selector */
    .shop-selector {
        margin: 20px 0;
        text-align: center;
    }

    .shop-selector label {
        display: block;
        margin-bottom: 10px;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
    }

    .shop-selector select {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 1em;
        width: 100%;
        max-width: 300px;
        transition: all 0.3s ease;
    }

    .shop-selector select:focus {
        outline: none;
        border-color: #f59e0b;
        background: rgba(255, 255, 255, 0.15);
    }

    /* Result display */
    .result {
        margin-top: 30px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        text-align: center;
        display: none;
    }

    .result.success {
        border: 2px solid #10b981;
        background: rgba(16, 185, 129, 0.1);
    }

    .result.error {
        border: 2px solid #ef4444;
        background: rgba(239, 68, 68, 0.1);
    }

    .result h3 {
        margin-bottom: 15px;
        font-size: 1.3em;
    }

    .worker-info {
        margin-top: 15px;
        text-align: left;
    }

    .worker-info p {
        margin: 8px 0;
        color: rgba(255, 255, 255, 0.8);
    }

    .worker-info strong {
        color: #f59e0b;
    }

    /* Manual input */
    .manual-input {
        margin-top: 30px;
        text-align: center;
    }

    .manual-input h4 {
        margin-bottom: 15px;
        color: rgba(255, 255, 255, 0.8);
    }

    .manual-input input {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 12px 20px;
        border-radius: 50px;
        font-size: 1em;
        width: 200px;
        margin-right: 10px;
        transition: all 0.3s ease;
    }

    .manual-input input:focus {
        outline: none;
        border-color: #f59e0b;
        background: rgba(255, 255, 255, 0.15);
    }

    .manual-input input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    /* Workers list */
    .workers-list {
        margin-top: 30px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
    }

    .workers-list h3 {
        color: #f59e0b;
        margin-bottom: 15px;
    }

    .worker-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .worker-card:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .worker-card .info {
        flex: 1;
    }

    .worker-card .info .name {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .worker-card .info .details {
        font-size: 0.9em;
        color: rgba(255, 255, 255, 0.6);
    }

    .worker-card .barcode {
        font-family: 'Courier New', monospace;
        font-size: 1.2em;
        font-weight: bold;
        padding: 10px 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        letter-spacing: 2px;
    }

    /* Loading animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #f59e0b;
        animation: spin 1s ease-in-out infinite;
        margin-left: 10px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Check-in/out indicator */
    .check-type {
        display: inline-block;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 600;
        margin-top: 10px;
    }

    .check-type.check-in {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid #10b981;
    }

    .check-type.check-out {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid #ef4444;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 20px;
        }
        
        .logo h1 {
            font-size: 2em;
        }
        
        .worker-card {
            flex-direction: column;
            text-align: center;
        }
        
        .worker-card .barcode {
            margin-top: 10px;
        }
    }
</style>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<div class="container">
    <div class="logo">
        <h1>Барбершоп</h1>
        <p>Система обліку робочого часу</p>
    </div>

    <!-- Shop selector -->
    <div class="shop-selector">
        <label for="shop-select">Оберіть барбершоп:</label>
        <select id="shop-select">
            <?php if ($this->shops) foreach ($this->shops as $shop): ?>
                <option value="<?= $shop->id ?>"><?= $shop->title ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Scanner container -->
    <div id="scanner-container">
        <div id="scanner"></div>
        <div class="scan-line"></div>
    </div>

    <!-- Controls -->
    <div class="controls">
        <button id="startBtn" class="btn">Почати сканування</button>
        <button id="stopBtn" class="btn secondary" style="display:none;">Зупинити</button>
    </div>

    <!-- Manual input -->
    <div class="manual-input">
        <h4>Ручне введення коду:</h4>
        <input type="text" id="manualCode" placeholder="Код працівника">
        <button class="btn secondary" onclick="processManualCode()">Ввести</button>
    </div>

    <!-- Result display -->
    <div id="result" class="result"></div>

    <!-- Workers list -->
    <div class="workers-list">
        <h3>Список працівників з кодами:</h3>
        <?php if ($this->masters) foreach ($this->masters as $master): ?>
            <div class="worker-card">
                <div class="info">
                    <div class="name"><?= $master->firstname . ' ' . $master->lastname ?></div>
                    <div class="details">
                        <?= $master->job_title ?: 'Майстер' ?>
                        <?php if ($master->shops): ?>
                            • <?= implode(', ', array_map(function($shop) { return $shop->title; }, $master->shops)) ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="barcode">CODE-<?= str_pad($master->id, 4, '0', STR_PAD_LEFT) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    let scanning = false;
    let lastScannedCode = '';
    let lastScanTime = 0;

    // Працівники з бази даних
    const workers = {
        <?php if ($this->masters) foreach ($this->masters as $master): ?>
        'CODE-<?= str_pad($master->id, 4, "0", STR_PAD_LEFT) ?>': {
            id: <?= $master->id ?>,
            name: '<?= addslashes($master->firstname . ' ' . $master->lastname) ?>',
            position: '<?= addslashes($master->job_title ?: 'Майстер') ?>',
            shops: <?= json_encode(array_map(function($shop) { return $shop->title; }, $master->shops ?: [])) ?>
        },
        '<?= $master->id ?>': {
            id: <?= $master->id ?>,
            name: '<?= addslashes($master->firstname . ' ' . $master->lastname) ?>',
            position: '<?= addslashes($master->job_title ?: 'Майстер') ?>',
            shops: <?= json_encode(array_map(function($shop) { return $shop->title; }, $master->shops ?: [])) ?>
        },
        <?php endforeach; ?>
    };
    
    console.log('Workers loaded:', workers); // Для отладки

    function initScanner() {
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#scanner'),
                constraints: {
                    width: 640,
                    height: 480,
                    facingMode: "environment"
                }
            },
            decoder: {
                readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader"]
            }
        }, function(err) {
            if (err) {
                console.log(err);
                showError("Помилка доступу до камери. Переконайтеся, що ви надали дозвіл.");
                return;
            }
            console.log("Сканер ініціалізовано");
            Quagga.start();
            scanning = true;
            document.getElementById('startBtn').style.display = 'none';
            document.getElementById('stopBtn').style.display = 'inline-block';
        });

        Quagga.onDetected(function(result) {
            const code = result.codeResult.code;
            const currentTime = Date.now();
            
            // Запобігання повторному скануванню
            if (code === lastScannedCode && currentTime - lastScanTime < 5000) {
                return;
            }
            
            lastScannedCode = code;
            lastScanTime = currentTime;
            
            processBarcode(code);
        });
    }

    function stopScanner() {
        if (scanning) {
            Quagga.stop();
            scanning = false;
            document.getElementById('startBtn').style.display = 'inline-block';
            document.getElementById('stopBtn').style.display = 'none';
        }
    }

    function processBarcode(code) {
        console.log("Відскановано код:", code);
        
        // Тимчасово зупиняємо сканер
        stopScanner();
        
        // Перевіряємо працівника
        const worker = workers[code];
        
        if (worker) {
            console.log("Знайдено працівника:", worker);
            recordAttendance(worker);
        } else {
            console.log("Працівника не знайдено. Код:", code);
            console.log("Доступні коди:", Object.keys(workers));
            showError("Працівника з кодом '" + code + "' не знайдено");
        }
    }

    function processManualCode() {
        const code = document.getElementById('manualCode').value.trim();
        if (code) {
            processBarcode(code);
            document.getElementById('manualCode').value = '';
        }
    }

    function showSuccess(worker, type, time) {
        const resultDiv = document.getElementById('result');
        const typeText = type === 'check_in' ? 'Прихід' : 'Вихід';
        const typeClass = type === 'check_in' ? 'check-in' : 'check-out';
        
        resultDiv.className = 'result success';
        resultDiv.innerHTML = `
            <h3>✓ Успішно зареєстровано</h3>
            <div class="worker-info">
                <p><strong>Працівник:</strong> ${worker.name}</p>
                <p><strong>Посада:</strong> ${worker.position}</p>
                <p><strong>Заклад:</strong> ${worker.shop}</p>
                <p><strong>Час:</strong> ${time}</p>
            </div>
            <div class="check-type ${typeClass}">${typeText}</div>
        `;
        resultDiv.style.display = 'block';
        
        // Автоматично приховуємо через 5 секунд
        setTimeout(() => {
            resultDiv.style.display = 'none';
        }, 5000);
    }

    function showError(message) {
        const resultDiv = document.getElementById('result');
        
        resultDiv.className = 'result error';
        resultDiv.innerHTML = `
            <h3>✗ Помилка</h3>
            <p>${message}</p>
        `;
        resultDiv.style.display = 'block';
        
        setTimeout(() => {
            resultDiv.style.display = 'none';
        }, 3000);
    }

    function recordAttendance(worker) {
        const shopId = document.getElementById('shop-select').value;
        
        // Показуємо завантаження
        const resultDiv = document.getElementById('result');
        resultDiv.className = 'result';
        resultDiv.innerHTML = '<div class="loading"></div> Реєстрація...';
        resultDiv.style.display = 'block';
        
        // AJAX запит
        $.ajax({
            url: site_url + 'page/attendance_record',
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: worker.id,
                shop_id: shopId
            },
            success: function(response) {
                console.log('Response:', response);
                
                if (response && response.success) {
                    showSuccess(response.user, response.type, response.time);
                } else {
                    showError(response.error || 'Помилка реєстрації');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response Text:', xhr.responseText);
                
                // Пробуем распарсить ответ, если это JSON
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        showError(response.error);
                    } else {
                        showError('Помилка сервера: ' + error);
                    }
                } catch(e) {
                    // Если не JSON, показываем общую ошибку
                    showError('Помилка з\'єднання з сервером. Перевірте консоль для деталей.');
                }
            }
        });
    }

    // Обробники подій
    document.getElementById('startBtn').addEventListener('click', initScanner);
    document.getElementById('stopBtn').addEventListener('click', stopScanner);
    
    // Обробка Enter в полі ручного вводу
    document.getElementById('manualCode').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            processManualCode();
        }
    });
</script>