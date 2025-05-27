<form id="form_box" action="{URL:panel/settings}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">
                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-gear"></a>
                                    <h1 class="page_title">Webcam Stream </h1>
                                </div>
                            </div>
                            
                            <div class="items_right-side hide_block1024">
                                <div class="items_small-block"></div>
                                <a class="btn btn-outline-warning" href="{URL:panel}"><i class="fas fa-reply"></i>Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Webcam Stream Section -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <!-- Video Element for Webcam Display -->
                                <div class="webcam-container">
                                    <video id="webcam" class="webcam-video" width="100%" height="auto" autoplay playsinline></video>
                                </div>
                                <!-- Status Message -->
                                <div id="webcamStatus" class="alert alert-info mt-2">Нажмите кнопку Play для запуска камеры</div>
                                <!-- Webcam Controls -->
                                <div class="webcam-controls mt-3 text-center">
                                    <button type="button" id="startWebcam" class="btn btn-success mr-2"><i class="fas fa-play"></i> Play</button>
                                    <button type="button" id="stopWebcam" class="btn btn-danger" disabled><i class="fas fa-stop"></i> Stop</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Webcam Functionality -->
    <script>
       document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('webcam');
    const startBtn = document.getElementById('startWebcam');
    const stopBtn = document.getElementById('stopWebcam');
    const statusDisplay = document.getElementById('webcamStatus');
    
    let cameraStream = null;
    
    // Проверка поддержки getUserMedia в разных браузерах
    // и определение доступного метода
    function setupUserMediaPolyfill() {
        navigator.getUserMedia = navigator.getUserMedia ||
                                 navigator.webkitGetUserMedia ||
                                 navigator.mozGetUserMedia ||
                                 navigator.msGetUserMedia;
        
        // Если mediaDevices не определен, создаем его
        if (navigator.mediaDevices === undefined) {
            navigator.mediaDevices = {};
        }
        
        // Если getUserMedia не определен, создаем его с помощью старого API
        if (navigator.mediaDevices.getUserMedia === undefined) {
            navigator.mediaDevices.getUserMedia = function(constraints) {
                // Используем старое API getUserMedia
                const getUserMedia = navigator.getUserMedia || 
                                     navigator.webkitGetUserMedia ||
                                     navigator.mozGetUserMedia || 
                                     navigator.msGetUserMedia;
                
                if (!getUserMedia) {
                    return Promise.reject(new Error('getUserMedia не поддерживается в этом браузере'));
                }
                
                // Оборачиваем старый API в Promise
                return new Promise(function(resolve, reject) {
                    getUserMedia.call(navigator, constraints, resolve, reject);
                });
            };
        }
    }
    
    // Устанавливаем полифилл перед использованием
    setupUserMediaPolyfill();
    
    // Функция для запуска камеры
    function startCamera() {
        // Обновляем статус
        statusDisplay.textContent = "Запрашиваем доступ к камере...";
        statusDisplay.className = "alert alert-warning mt-2";
        
        // Отключаем кнопку Play
        startBtn.disabled = true;
        
        // Настройки камеры
        const constraints = {
            audio: false,
            video: {
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        };
        
        // Запрашиваем доступ к камере с короткой задержкой
        setTimeout(() => {
            // Проверяем наличие API
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                // Используем современный API
                navigator.mediaDevices.getUserMedia(constraints)
                    .then(handleSuccess)
                    .catch(handleError);
            } else if (navigator.getUserMedia) {
                // Используем старый API как запасной вариант
                navigator.getUserMedia(constraints, handleSuccess, handleError);
            } else {
                // Ни один метод не доступен
                handleError(new Error('getUserMedia не поддерживается в этом браузере'));
            }
        }, 100);
    }
    
    // Обработчик успешного получения потока
    function handleSuccess(stream) {
        // Сохраняем поток
        cameraStream = stream;
        
        try {
            // Для современных браузеров
            video.srcObject = stream;
        } catch (error) {
            // Для старых браузеров
            let vendorURL = window.URL || window.webkitURL;
            video.src = vendorURL.createObjectURL(stream);
        }
        
        // Обработка загрузки метаданных видео
        video.onloadedmetadata = function() {
            video.play()
                .then(() => {
                    // Обновляем UI при успешном запуске
                    statusDisplay.textContent = "Камера успешно запущена";
                    statusDisplay.className = "alert alert-success mt-2";
                    stopBtn.disabled = false;
                })
                .catch((err) => {
                    statusDisplay.textContent = "Ошибка воспроизведения: " + err.message;
                    statusDisplay.className = "alert alert-danger mt-2";
                    startBtn.disabled = false;
                });
        };
    }
    
    // Обработчик ошибок
    function handleError(err) {
        startBtn.disabled = false;
        
        console.error('Ошибка getUserMedia:', err.name, err.message);
        
        // Формируем понятное сообщение об ошибке
        let errorMsg = "";
        
        if (err.name) {
            switch (err.name) {
                case 'NotAllowedError':
                case 'PermissionDeniedError': // Старое название для NotAllowedError
                    errorMsg = "Доступ к камере запрещен пользователем или системой";
                    
                    // Информация о локальном хосте
                    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                        errorMsg += ". Для Chrome на локальном сервере убедитесь, что вы запустили его с параметром --unsafely-treat-insecure-origin-as-secure=http://localhost";
                    }
                    break;
                    
                case 'NotFoundError':
                case 'DevicesNotFoundError': // Старое название
                    errorMsg = "Камера не найдена. Проверьте подключение вашей веб-камеры";
                    break;
                    
                case 'NotReadableError':
                case 'TrackStartError': // Старое название
                    errorMsg = "Камера недоступна или уже используется другим приложением";
                    break;
                    
                case 'AbortError':
                    errorMsg = "Операция была прервана";
                    break;
                    
                case 'TypeError':
                    errorMsg = "Несовместимые параметры запроса камеры";
                    break;
                    
                default:
                    errorMsg = "Ошибка доступа к камере: " + (err.message || "неизвестная ошибка");
            }
        } else {
            errorMsg = "Ошибка доступа к камере: " + (err.message || err.toString() || "неизвестная ошибка");
        }
        
        statusDisplay.textContent = errorMsg;
        statusDisplay.className = "alert alert-danger mt-2";
    }
    
    // Функция для остановки камеры
    function stopCamera() {
        if (cameraStream) {
            // Останавливаем каждый трек в потоке
            cameraStream.getTracks().forEach(function(track) {
                track.stop();
            });
            
            // Очищаем источник видео
            try {
                video.srcObject = null;
            } catch (error) {
                video.src = "";
            }
            
            cameraStream = null;
            
            // Обновляем UI
            statusDisplay.textContent = "Камера остановлена";
            statusDisplay.className = "alert alert-info mt-2";
            stopBtn.disabled = true;
            startBtn.disabled = false;
        }
    }
    
    // Подсказка для локального хоста в Chrome
    if (window.location.protocol === 'http:' && 
        (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1')) {
        
        statusDisplay.innerHTML = "Локальный хост через HTTP: для Chrome может потребоваться разрешить небезопасное происхождение. " + 
                                 "Рекомендуется запустить Chrome с флагом:<br><code>--unsafely-treat-insecure-origin-as-secure=http://localhost</code>";
        statusDisplay.className = "alert alert-warning mt-2";
    }
    
    // Назначаем обработчики событий для кнопок
    startBtn.addEventListener('click', startCamera);
    stopBtn.addEventListener('click', stopCamera);
});
    </script>
</form>