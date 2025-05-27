
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }


        .main {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 90%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-size: 2.5em;
            background: linear-gradient(45deg, #f39c12, #e74c3c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .logo p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1em;
        }

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
            background: linear-gradient(90deg, transparent, #f39c12, transparent);
            animation: scan 2s linear infinite;
        }

        @keyframes scan {
            0% { transform: translateY(0); }
            100% { transform: translateY(298px); }
        }

        .controls {
            text-align: center;
            margin-top: 30px;
        }

        .btn {
            background: linear-gradient(45deg, #f39c12, #e74c3c);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1em;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(243, 156, 18, 0.3);
            margin: 10px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(243, 156, 18, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn.secondary {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .result {
            margin-top: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            text-align: center;
            display: none;
        }

        .result.success {
            border: 2px solid #27ae60;
            background: rgba(39, 174, 96, 0.1);
        }

        .result.error {
            border: 2px solid #e74c3c;
            background: rgba(231, 76, 60, 0.1);
        }

        .result h3 {
            margin-bottom: 10px;
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
            color: #f39c12;
        }

        .manual-input {
            margin-top: 30px;
            text-align: center;
        }

        .manual-input input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px 20px;
            border-radius: 50px;
            font-size: 1em;
            width: 60%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .manual-input input:focus {
            outline: none;
            border-color: #f39c12;
            background: rgba(255, 255, 255, 0.15);
        }

        .manual-input input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #f39c12;
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .error-message {
            color: #e74c3c;
            margin-top: 10px;
            display: none;
        }
    </style>
    
    <div class="container">
        <div class="logo">
            <h1>Папа+Син</h1>
            <p>Система обліку робочого часу</p>
        </div>

        <div id="scanner-container">
            <div id="scanner"></div>
            <div class="scan-line"></div>
        </div>

        <div class="controls">
            <button id="startBtn" class="btn">Почати сканування</button>
            <button id="stopBtn" class="btn secondary" style="display:none;">Зупинити</button>
        </div>

        <div class="manual-input">
            <input type="text" id="manualCode" placeholder="Введіть ID працівника">
            <button class="btn secondary" onclick="processManualCode()">Ввести</button>
        </div>

        <div id="result" class="result"></div>
        <div id="error-message" class="error-message"></div>
        
        <div style="margin-top: 30px; padding: 20px; background: rgba(255, 255, 255, 0.05); border-radius: 15px;">
            <h3 style="color: #f39c12; margin-bottom: 15px;">Тестові ID працівників:</h3>
            <div style="display: grid; gap: 10px; color: rgba(255, 255, 255, 0.8);">
                <div>ID: <strong>1</strong> - Alex Userov</div>
                <div>ID: <strong>2</strong> - Admin Admin</div>
                <div>ID: <strong>3</strong> - Олег Master</div>
                <div>ID: <strong>4</strong> - Manager Manager</div>
                <div>ID: <strong>5</strong> - Back Back</div>
            </div>
        </div>
    </div>

    <script>
        let scanning = false;
        let lastScannedCode = '';
        let lastScanTime = 0;

        // Працівники з бази даних - використовуємо ID як штрих-код
        const workers = {
            '1': { id: 1, name: 'Alex Userov', position: 'Developers', shop: 'Папа+Син Segedska' },
            '2': { id: 2, name: 'Admin Admin', position: 'Manager', shop: 'Папа+сын Ген.Петрова' },
            '3': { id: 3, name: 'Олег Master', position: 'Топ Мастер', shop: 'Папа+Син Segedska' },
            '4': { id: 4, name: 'Manager Manager', position: 'Front', shop: 'Папа+Син Segedska' },
            '5': { id: 5, name: 'Back Back', position: 'Back', shop: 'Папа+сын Ген.Петрова' }
        };

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
                    readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader"]
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
                
                // Запобігання повторному скануванню того ж коду протягом 5 секунд
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
                showSuccess(worker);
                recordAttendance(worker);
            } else {
                showError("Працівника з таким кодом не знайдено");
            }
        }

        function processManualCode() {
            const code = document.getElementById('manualCode').value.trim();
            if (code) {
                processBarcode(code);
                document.getElementById('manualCode').value = '';
            }
        }

        function showSuccess(worker) {
            const resultDiv = document.getElementById('result');
            const currentTime = new Date().toLocaleString('uk-UA');
            
            resultDiv.className = 'result success';
            resultDiv.innerHTML = `
                <h3>✓ Успішно зареєстровано</h3>
                <div class="worker-info">
                    <p><strong>Працівник:</strong> ${worker.name}</p>
                    <p><strong>Посада:</strong> ${worker.position}</p>
                    <p><strong>Заклад:</strong> ${worker.shop}</p>
                    <p><strong>Час:</strong> ${currentTime}</p>
                </div>
            `;
            resultDiv.style.display = 'block';
            
            // Автоматично приховуємо результат через 5 секунд
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
        // AJAX запит до сервера для запису в БД
        console.log('Записуємо відвідування:', worker);
        
        fetch('/panel/attendance/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'barcode=' + worker.id + '&shop_id=' + (worker.shop_id || 1)
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Відвідування записано');
            } else {
                console.error('Помилка запису:', data.error);
            }
        }).catch(error => {
            console.error('Помилка запису:', error);
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